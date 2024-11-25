<?php

namespace App\Services\User;

use App\Foundations\Exceptions\FatalErrorException;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    )
    {
        //
    }

    public function getAllUsers(Request $request)
    {
        $params = array_merge($request->all(), ['with' => 'roles']);
        return $this->userRepository->all($params);
    }

    public function createUser(Request $request): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $data = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:50',

        ]);

        try {
            DB::beginTransaction();

            $user = $this->userRepository->insert($data);

            $user->assignRole($request->get('type'));
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new FatalErrorException($exception->getMessage());
        }

        return $user;
    }

    public function getUserByUuid($uuid, $relation = [])
    {
        $user = $this->userRepository->getDataByUuid($uuid ,$relation);

        if(!$user) {
            throw new NotFoundResourceException('User Not Found', 404);
        }

        return $user;
    }

    public function updateUser($user, $request)
    {
        $data = $request->only('name', 'email');
        $type = $request->get('type');
        try{
            DB::beginTransaction();
            $this->userRepository->update($data, $user->id);
            $user->assignRole($type);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new FatalErrorException($exception->getMessage());
        }
        return $user;
    }

    public function deleteUser($user)
    {
        try {
            DB::beginTransaction();
            $this->userRepository->destroy($user->id);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new FatalErrorException($exception->getMessage());
        }
        return true;
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    )
    {
        //
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request);

        return Inertia::render('User/Index', ['users' => $users]);
    }

    public function create()
    {
        $roles = [
            [
                'type' => config('constant.user_types.publisher')
            ],
            [
                'type' => config('constant.user_types.advertiser')
            ]

        ];
        return Inertia::render('User/Create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $this->userService->createUser($request);

        return redirect()->route('users.index');
    }

    public function show($id)
    {

    }

    public function edit($uuid)
    {
        $roles = [
            [
                'type' => config('constant.user_types.publisher')
            ],
            [
                'type' => config('constant.user_types.advertiser')
            ]

        ];

        $user = $this->userService->getUserByUuid($uuid ,['roles']);

        return Inertia::render('User/Create', ['roles' => $roles, 'user' => $user]);
    }

    public function update($uuid, Request $request)
    {
        $user = $this->userService->getUserByUuid($uuid);

        $this->userService->updateUser($user, $request);

        return redirect()->route('users.index');
    }

    public function destroy($uuid)
    {
        $user = $this->userService->getUserByUuid($uuid);

        $response = $this->userService->deleteUser($user);
        if(!$response) {
            return redirect()->route('users.index')->with('error', 'Error occurred while deleting the user.');
        }
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}

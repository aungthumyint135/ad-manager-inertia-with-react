<?php

namespace App\Repositories\User;

use App\Foundations\BaseRepository\BaseRepository;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function connection(): Model
    {
        return new User();
    }

    protected function optionsQuery(array $options)
    {
        $query = parent::optionsQuery($options);

        if (!empty($options['search'])) {
            $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'like', "%{$options['search']}%")
                ->orWhere('email', 'like', "%{$options['search']}%");
            });
        }

        return $query;
    }
}

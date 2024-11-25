<?php

namespace App\Repositories\Agency;

use App\Foundations\BaseRepository\BaseRepository;
use App\Models\Agency\Agency;
use Illuminate\Database\Eloquent\Model;

class AgencyRepository extends BaseRepository implements AgencyRepositoryInterface
{

    public function connection(): Model
    {
        return new Agency();
    }

    protected function optionsQuery(array $options)
    {
        $query = parent::optionsQuery($options);

        if (!empty($options['search'])) {
            $query->where(function ($query) use ($options) {
                $query->orWhere('name', 'like', "%{$options['search']}%");
            });
        }

        return $query;
    }
}

<?php

namespace App\Models\Agency;

use App\Foundations\Traits\HasUUID;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    use HasFactory, HasUUID;

    protected $fillable = [
        'name',
        'is_active',
        'network_code'
    ];


    //relationsship
    public function users():HasMany
    {
        return $this->hasMany(User::class);
    }

    public function owner():HasMany
    {
        return $this->hasMany(User::class);
    }
}

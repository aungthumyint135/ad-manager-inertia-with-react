<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Tenant
{
    public static function bootTenant()
    {
        if (auth()->check()) {
            static::creating(function ($model) {
                $model->agency_id = auth()->user()->agency_id;
            });
        };

        if(auth()->check() && !Auth::guard('admin')->check()){
            static::addGlobalScope('agency_id', function ($builder) {
                $builder->where('agency_id', auth()->user()->agency_id);
            });
        }
    }
}

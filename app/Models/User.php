<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Orders;

class User extends Authenticatable
{
    use SoftDeletes;

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function orderspdf()
    {
        return $this->hasMany(Orders::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_user');
    }
}

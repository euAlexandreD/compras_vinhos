<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Orders;

class User extends Model
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{

    use SoftDeletes;

    public function users()
    {
        $this->hasOne(User::class);
    }

    public function statuses()
    {
        $this->hasOne(Statuses::class);
    }
}

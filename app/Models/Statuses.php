<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statuses extends Model
{



    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}

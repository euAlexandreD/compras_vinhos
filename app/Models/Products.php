<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{

    use SoftDeletes;

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Orders extends Model
{

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'status_id',
        'total_price',
    ];



    public function items()
    {
        return $this->hasMany(OrdemItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function status()
    {
        return $this->belongsTo(Statuses::class, 'status_id');
    }
}

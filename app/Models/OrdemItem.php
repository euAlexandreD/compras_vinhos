<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemItem extends Model
{

    protected $table = 'ordem_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}

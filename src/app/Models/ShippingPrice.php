<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{

    public static $defaultPrice = 9.99;

    protected $table = 'shipping_prices';

    protected $fillable = [
        'address',
        'price',
    ];


}

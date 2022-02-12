<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array'
    ];

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_email',
        'status',
        'items',
        'address',
        'delivery_price',
        'items_price',
        'total',
        'expected_delivery'
    ];

    protected $table = 'orders';

    protected $dates = [
        'expected_delivery'
    ];

    public function calcTotals($items, $delivery_price = 0): array
    {

        $items = json_decode($items);
        $subtotal = 0;

        if (!empty($items)) {
            foreach ($items as $item) {
                if (!empty($item->unit_price) && !empty($item->qty)) {
                    $unit_price = floatval($item->unit_price);
                    $quantity = floatval($item->qty);
                    $subtotal = $subtotal + $unit_price * $quantity;
                }
            }
        }

        return array(
            'subtotal' => $subtotal,
            'delivery' => $delivery_price,
            'total' => $subtotal + $delivery_price
        );

    }

}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    public function canCalculateShipping(): bool
    {
        return $this->role === 'customer';
    }

    public function canViewOrder(): bool
    {
        $can_view = false;

        if(in_array($this->role, ['courier', 'sales_manager'])) {
            $can_view = true;
        }

        return $can_view;
    }

    public function canCreateOrder(): bool
    {
        $can_view = false;

        if(in_array($this->role, ['customer', 'sales_manager'])) {
            $can_view = true;
        }

        return $can_view;
    }

    /**
     * @param ShippingPrice|null $shippingPrice
     * @return float
     */
    public function getDeliveryPrice(ShippingPrice $shippingPrice = null): float
    {
        $price = ShippingPrice::$defaultPrice;
        if(!empty($shippingPrice->price)) {
            $price = $shippingPrice->price;
        }

        if(empty($shippingPrice)) {
            $shippingPrice = ShippingPrice::where('address', '=', $this->address)->get()->first();

            if(!empty($shippingPrice->price)) {
                $price = $shippingPrice->price;
            }
        }

        return floatval($price);
    }


}

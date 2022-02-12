<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = User::findOrFail(1);

        $items = [
            [
                'name' => 'CoCa Cola',
                'qty' => 1,
                'unit_price' => 2.00
            ],
            [
                'name' => 'Sprite',
                'qty' => 2,
                'unit_price' => 1.80
            ]
        ];

        $orders = [
            [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'status' => 'pending',
                'items' => json_encode($items),
                'address' => $customer->address,
                'delivery_price' => 5.99,
                'items_price' => 5.6,
                'total' => 11.59,
                'expected_delivery' => now()->addDays(3)
            ]
        ];

        foreach ($orders as $orderData) {
            Order::create($orderData);
        }
    }
}

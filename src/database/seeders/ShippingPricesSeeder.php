<?php

namespace Database\Seeders;

use App\Models\ShippingPrice;
use Illuminate\Database\Seeder;

class ShippingPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prices = [
            [
                'address' => 'Brivibas street 123 LV-1011, Riga',
                'price' => 5.99,
            ],
            [
                'address' => 'Getrudes street 456 LV-1033, Riga',
                'price' =>  2.99,
            ],
        ];

        foreach ($prices as  $priceData) {
            ShippingPrice::create($priceData);
        }
    }
}

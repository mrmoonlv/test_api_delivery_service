<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Customer 1',
                'email' => 'customer1@example.com',
                'role' => 'customer',
                'address' => 'Brivibas street 123 LV-1011, Riga',
                'token' => '9c92n3i29ni3291i31093i92i3293',
            ],
            [
                'name' => 'Customer 2',
                'email' => 'customer2@example.com',
                'role' => 'customer',
                'address' => 'Getrudes street 456 LV-1033, Riga',
                'token' => 'dfldkf034k3lk13045l24k240240k',

            ],
            [
                'name' => 'Customer 3',
                'email' => 'customer3@example.com',
                'role' => 'customer',
                'address' => 'Vainodes street 12, LV-1000, Riga',
                'token' => 'c34m34304cj304c93403940394304',
            ],
            [
                'name' => 'Delivery Agent',
                'email' => 'courier@example.com',
                'role' => 'courier',
                'address' => null,
                'token' => '9c9c34m304i304i2l4024i02i3293',
            ],
            [
                'name' => 'Sales Manager',
                'email' => 'sales_manager@example.com',
                'role' => 'sales_manager',
                'address' => null,
                'token' => '9cmscklsdkn249jto33204i204400',
            ]
        ];

        foreach ($users as  $userData) {
            User::create($userData);
        }

    }
}

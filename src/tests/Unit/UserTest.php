<?php

namespace Tests\Unit;

use App\Models\ShippingPrice;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public $user;
    public $shipping_price;

    /**
     * UserTest constructor.
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->user = new User();
        parent::__construct($name, $data, $dataName);
    }

    public function usersRolesCalculateShippingDataProvider(): array
    {
        return [
            ['customer', true],
            ['courier', false],
            ['sales_manager', false],
        ];
    }

    /**
     * @dataProvider usersRolesCalculateShippingDataProvider
     */
    public function test_can_calculate_shipping($role, $expected)
    {
        $this->user->role = $role;
        $actual = $this->user->canCalculateShipping();
        $this->assertEquals($actual, $expected);
    }

    /**
     * @return array[]
     */
    public function usersCanViewDataOrderDataProvider(): array
    {
        return [
            ['customer', false],
            ['courier', true],
            ['sales_manager', true],
        ];
    }

    /**
     * @dataProvider usersCanViewDataOrderDataProvider
     */
    public function test_can_view_order($role, $expected)
    {
        $this->user->role = $role;
        $actual = $this->user->canViewOrder();
        $this->assertEquals($actual, $expected);
    }


    public function usersCanCreateOrderDataProvider(): array
    {
        return [
            ['customer', true],
            ['courier', false],
            ['sales_manager', true],
        ];
    }

    /**
     * @dataProvider usersCanCreateOrderDataProvider
     */
    public function test_can_create_order($role, $expected)
    {
        $this->user->role = $role;
        $actual = $this->user->canCreateOrder();
        $this->assertEquals($actual, $expected);
    }


    public function deliverPricesDataProvider(): array
    {
        return [
            [123, 123],
            [123.4, 123.4],
            ['1', 1],
            [null, 9.99],
        ];
    }

    /**
     * @dataProvider deliverPricesDataProvider
     */
    public function test_have_deliver_price($price, $expected)
    {
        $shippingPrice = new ShippingPrice();
        $shippingPrice->price = $price;

        $actual = $this->user->getDeliveryPrice($shippingPrice);
        $this->assertEquals($actual, $expected);
    }


}

<?php

namespace Tests\Unit;

use App\Models\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public $order;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->order = new Order();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @return array[]
     */
    public function orderItemDataProvider(): array
    {
        return [
            [
               '[{"name":"Pica","qty":3,"unit_price":1.50},{"name":"Sprite","qty":2,"unit_price":1.8}]',
                3,
                [
                    'subtotal' => 8.1,
                    'delivery' => 3,
                    'total' => 11.1
                ]
            ],
            [
              '[]',
                1,
                [
                    'subtotal' => 0,
                    'delivery' => 1,
                    'total' => 1
                ]
            ],
            [
                '[not-valid-json-value]',
                '0.00',
                [
                    'subtotal' => 0,
                    'delivery' => 0,
                    'total' => 0
                ]
            ],
            [
                '[not-valid-json-value]',
                '0.111',
                [
                    'subtotal' => 0,
                    'delivery' => 0.111,
                    'total' => 0.111
                ]
            ]
        ];
    }

    /**
     * @dataProvider orderItemDataProvider
     */
    public function test_calc_totals($items, $delivery_price, $expected)
    {
        $actual = $this->order->calcTotals($items, $delivery_price);
        $this->assertEquals($actual, $expected);
    }
}

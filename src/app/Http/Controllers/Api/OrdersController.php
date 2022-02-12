<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\User;
use App\Rules\OrderItemsIsValid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class OrdersController extends Controller
{

    public function getOrdersAction(Request $request): JsonResponse
    {
        $data = [];
        $orders = Order::all();

        foreach ($orders as $order) {
            unset($order->items);
            if ($request->get('user_role') == 'courier') {
                unset($order->id, $order->customer_id, $order->items_price, $order->total);
            }
            $data[] = $order;
        }

        $orders = $data;

        return response()->json($orders);
    }

    public function getOrderAction(Request $request, $order_id): JsonResponse
    {
        $order = Order::find($order_id);

        if (empty($order)) {
            return response()->json(['status' => 'false', 'message' => 'Order not found'], 404);
        }


        if ($request->get('user_role') == 'courier') {
            $items = [];
            foreach (json_decode($order->items) as $item) {
                $items[] = [
                    'name' => $item->name,
                    'qty' => $item->qty
                ];
            }

            $order->items = $items;
            unset($order->customer_id, $order->items_price, $order->total);
        }

        return response()->json($order);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createOrderAction(Request $request): JsonResponse
    {
        $token = $request->header('token');
        $user = User::where('token', '=', $token)->get()->first();

        $validator = Validator::make($request->all(), [
            'items' => ['required', 'json', new OrderItemsIsValid],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', ['errors' => $validator->messages()->all()]]);
        }

        $order = new Order();
        $totals = $order->calcTotals($request->items, $user->getDeliveryPrice());
        $order->customer_id = $user->id;
        $order->customer_name = $user->name;
        $order->customer_email = $user->email;
        $order->status = 'pending';
        $order->items = $request->items;
        $order->address = $user->address;
        $order->delivery_price = $totals['delivery'];
        $order->items_price = $totals['subtotal'];
        $order->total = $totals['total'];
        $order->expected_delivery = now()->addDays(3);

        $order->save();

        return response()->json(['status' => 'success', 'order_id' => $order->id]);
    }

}

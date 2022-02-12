<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShippingPriceController;
use App\Http\Controllers\Api\OrdersController;

Route::get('/calcPrice', [ShippingPriceController::class, 'calculatePriceAction'])->name('shipping_cost_calculation');
Route::get('/orders', [OrdersController::class, 'getOrdersAction'])->name('get_orders_list');
Route::post('/orders/create', [OrdersController::class, 'createOrderAction'])->name('create_order');
Route::get('/orders/{id}', [OrdersController::class, 'getOrderAction'])->name('get_order_information');

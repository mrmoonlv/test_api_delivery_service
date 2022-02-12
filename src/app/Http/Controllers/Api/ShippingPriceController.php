<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ShippingPriceController extends Controller
{

    public function calculatePriceAction(Request $request) {
        $token = $request->header('token');
        $user = User::where('token', '=', $token)->get()->first();

        return $user->getDeliveryPrice();
    }

}

<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;


class CheckIfTokenIsValid
{
    /**
     * @var ResponseFactory
     */
    protected $responseFactory;

    /**
     * JsonResponseMiddleware constructor.
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->header('token');

        if(empty($token)) {
            return response()->json(['status' => 'false', 'message' => 'Token missing'], 401);
        }

        $user = User::where('token', '=', $token)->get()->first();

        if(empty($user)){
            return response()->json(['status' => 'false', 'message' => 'User not found'], 404);
        }

        $action = $request->route()->getName();

        if(
            ($action === 'shipping_cost_calculation' && $user->canCalculateShipping() === false) ||
            ($action === 'get_orders_list' && $user->canViewOrder() === false) ||
            ($action === 'get_order_information' && $user->canViewOrder() === false) ||
            ($action === 'create_order' && $user->canCreateOrder() === false)
        ) {
            return response()->json(['status' => 'false', 'message' => 'Not allowed method'], 401);
        }

        $request->request->add(['user_role' => $user->role]);

        return $next($request);
    }
}

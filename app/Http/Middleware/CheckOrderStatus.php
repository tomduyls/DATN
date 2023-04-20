<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class CheckOrderStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $order_id = $request->route()->parameter('order');
        $order = Order::where("id", $order_id)->get();
        if ($order[0]->status == \App\Utilities\Constant::order_status_Finish || $order[0]->status == \App\Utilities\Constant::order_status_Cancel) {
            return redirect('./admin/order');
        }
        return $next($request);
    }
}

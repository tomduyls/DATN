<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() 
    {
        //Sales chart
        $orders = DB::table('orders')->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                    ->selectRaw('MONTH(orders.created_at) as month, COUNT( DISTINCT orders.id ) as count, SUM(qty) as sum')
                                    ->where('status', 3)
                                    ->whereYear('orders.created_at', date('Y'))
                                    ->groupBy('month')
                                    ->orderBy('month')
                                    ->get();
        
        $labels = [];
        $order_data = [];
        $product_data = [];

        for ($i=1; $i<12; $i++) {
            $month = date('F', mktime(0,0,0,$i,1));
            $count = 0;
            $sum = 0;

            foreach($orders as $order) {
                if($order->month == $i) {
                    $count = $order->count;
                    $sum = $order->sum;
                    break;
                }
            }

            array_push($labels, $month);
            array_push($order_data, $count);
            array_push($product_data, $sum);
        }

        $datasets = [
            [
                'label' => "Orders",
                'data' => $order_data,
            ],
            [
                'label' => "Products",
                'data' => $product_data,
            ]
        ];

        //Stats
        $newOrders = Order::where('status', 1)
                            ->select()->count();
        
        $users = User::all()->count();

        $coupons = Coupon::all()->count();

        $blogs = Blog::all()->count();

        return view('admin.index', compact('datasets', 'labels', 'newOrders', 'users', 'coupons', 'blogs'));
    }
}

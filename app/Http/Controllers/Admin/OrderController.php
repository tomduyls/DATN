<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductDetail;
use App\Service\Order\OrderServiceInterface;
use App\Service\Product\ProductServiceInterface;
use App\Utilities\Constant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;
    private $productService;

    public function __construct(OrderServiceInterface $orderService, ProductServiceInterface $productService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->searchAndPaginate('first_name', $request->get('search'));

        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderService->find($id);

        return  view('admin.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderService->find($id);
        return view('admin.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->orderService->update($data, $id);
        if($request->status == Constant::order_status_Cancel) {

            $order = $this->orderService->find($id);

            foreach($order->orderDetails as $orderDetail) {
                $productDetail = ProductDetail::where('product_id', $orderDetail->product_id)->where('size', $orderDetail->size)->get();
                $productDetailQty = $productDetail[0]->qty + $orderDetail->qty;
                ProductDetail::where('product_id', $orderDetail->product_id)->where('size', $orderDetail->size)->update(['qty' => $productDetailQty]);

                $product = $this->productService->find($orderDetail->product_id);
                $productQty = $product->qty + $orderDetail->qty;
                $this->productService->update(['qty' => $productQty], $orderDetail->product_id);
            }
        }
            

        return redirect('/admin/order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

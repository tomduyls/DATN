<?php

namespace App\Http\Controllers\Front;


use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Service\Product\ProductServiceInterface;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckOutController extends Controller
{
    private $orderService;
    private $orderDetailService;
    private $productService;

    public function __construct(OrderServiceInterface $orderService,
                                OrderDetailServiceInterface $orderDetailService,
                                ProductServiceInterface $productService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
        $this->productService = $productService;
    }

    public function index()
    {
        $carts = Cart::content();
        $total = Cart::total();
        $subtotal = Cart::subtotal();
        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }

    public function addOrder(Request $request)
    {
        //01. Them don hang
        $data = $request->all();
        $data['status'] = Constant::order_status_ReceiveOrders;
        $order = $this->orderService->create($data);

        //02. Them chi tiet don hang
        $carts = Cart::content();
        foreach ($carts as $cart) {
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'qty' => $cart->qty,
                'size' => $cart->options->size,
                'amount' => $cart->price,
                'total' => $cart->qty * $cart->price,
            ];
            $this->orderDetailService->create($data);

            $productDetail= ProductDetail::where('product_id', $cart->id)->where('size', $cart->options->size)->get();
            $productDetailQty = $productDetail[0]->qty - $cart->qty;
            
            ProductDetail::where('product_id', $cart->id)->where('size', $cart->options->size)->update(['qty' => $productDetailQty]);

            $product = $this->productService->find($cart->id);
            $productQty = $product->qty - $cart->qty;
            $this->productService->update(['qty' => $productQty], $cart->id);
        };

        //03. Xoa don hang
        Cart::destroy();

        //04.Tra ket qua thong bao
        return redirect('checkout/result')->with('notification', "Success! You will pay on delivery. Please check your email.");
    }

    public function result()
    {
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));
    }
}

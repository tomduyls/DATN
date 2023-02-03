<?php

namespace App\Http\Controllers\Front;


use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use App\Service\Product\ProductServiceInterface;
use App\Service\User\UserServiceInterface;
use App\Utilities\Constant;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckOutController extends Controller
{
    private $orderService;
    private $orderDetailService;
    private $productService;
    private $userService;

    public function __construct(OrderServiceInterface $orderService,
                                OrderDetailServiceInterface $orderDetailService,
                                ProductServiceInterface $productService,
                                UserServiceInterface $userService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
        $this->productService = $productService;
        $this->userService = $userService;
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
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required',
            'postcode_zip' => 'required',
            'street_address' => 'required',
            'phone' => 'required|digits_between:9,10',
            // 'email' => 'email:rfc,dns'
        ]);

        //Tao tai khoan
        if(Auth::guest()) {
            $request->validate([
                'email' => 'required|email|unique:users,email'
            ]);

            $user_updated = [
                'name' => $request->first_name,
                'email' => $request->email,
                'password' => bcrypt(Str::random(10)),
                'level' => Constant::user_level_client,
                'token' => Str::random(10)
            ];

            $this->userService->create($user_updated);
            $user_updated_id = $this->userService->getUserByEmail($request->email)[0]->id;
            $email_to = $request->email;
            Mail::send('front.checkout.createAccEmail',
                compact('user_updated', 'user_updated_id'), 
                function($message) use($email_to) {
                    $message->from('codelean@gmail.com', "CodeLean eShop");
                    $message->subject('Account created');
                    $message->to($email_to, $email_to);
                });
            
        }

        //01. Them don hang
        $data = $request->all();
        
        if(Auth::guest()) 
            $data['user_id'] = $this->userService->getUserByEmail($request->email)[0]->id;

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

            $this->updateQty($cart);
        };

        //Gui email
        $total = Cart::total();
        $subtotal = Cart::subtotal();

        $this->sendEmail($order, $total, $subtotal);

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

    public function updateQty($cart)
    {
        $productDetail= ProductDetail::where('product_id', $cart->id)->where('size', $cart->options->size)->get();
        $productDetailQty = $productDetail[0]->qty - $cart->qty;
        
        ProductDetail::where('product_id', $cart->id)->where('size', $cart->options->size)->update(['qty' => $productDetailQty]);

        $product = $this->productService->find($cart->id);
        $productQty = $product->qty - $cart->qty;
        $this->productService->update(['qty' => $productQty], $cart->id);
    }

    private function sendEmail($order, $total, $subtotal) 
    {
        $email_to = $order->email;

        Mail::send('front.checkout.orderEmail',
                compact('order', 'total', 'subtotal'),
                function ($message) use ($email_to) {
                    $message->from('codelean@gmail.com', "CodeLean eShop");
                    $message->to($email_to, $email_to);
                    $message->subject('Order Notification');
                });
    }
}

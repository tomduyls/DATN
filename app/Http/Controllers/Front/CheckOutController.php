<?php

namespace App\Http\Controllers\Front;


use App\Service\Order\OrderServiceInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use App\Service\Product\ProductServiceInterface;
use App\Service\User\UserServiceInterface;
use App\Utilities\Common;
use App\Utilities\Constant;
use App\Utilities\VNPay;
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
        $percentageDiscount = Common::percentageDiscount();
        $fixedDiscount = Cart::tax();
        return view('front.checkout.index', compact('carts', 'total', 'percentageDiscount', 'fixedDiscount'));
    }

    public function addOrder(Request $request)
    {
        //Revalidate so luong hang
        $carts = Cart::content();
        
        foreach($carts as $cart){
            $productDetail = ProductDetail::where('product_id', $cart->id)->where('size', $cart->options->size)->get();
            $qty_check = $productDetail[0]->qty;
            
            if($cart->qty > $qty_check){
                $message = $cart->name . " " . $cart->options->size . " only has " . $productDetail[0]->qty .  " available, please check your Cart to change!";
                return redirect('checkout/result')->with('notification', $message); 
            }
        }
        
        //Validate du lieu
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

        //Them don hang
        $data = $request->all();
        
        if(Auth::guest()) 
            $data['user_id'] = $this->userService->getUserByEmail($request->email)[0]->id;

        $data['status'] = Constant::order_status_ReceiveOrders;
        $order = $this->orderService->create($data);

        //Them chi tiet don hang
        $cart_key = $carts->keys();
        $cart_first_item = Cart::get($cart_key[0]);
        $coupon = Coupon::where('code', $cart_first_item->options->coupon)->get();
        $coupon_id = 0;

        if($coupon->count() > 0) 
            $coupon_id = $coupon[0]->id;

        foreach ($carts as $cart) {
            
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'coupon_id' => $coupon_id,
                'qty' => $cart->qty,
                'size' => $cart->options->size,
                'amount' => $cart->price,
                'total' => $cart->qty * $cart->price,
            ];
            
            if($coupon_id == 0) unset($data['coupon_id']);

            $this->orderDetailService->create($data);

            $this->updateQty($cart);
        };

        //Update coupon
        if($coupon->count() > 0) 
            $this->updateCoupon($cart_first_item->options->coupon);

        if($request->payment_type == 'pay_later') {
            //Gui email
            $price_total = Cart::priceTotal();
            $total = Cart::total();
            $percentageDiscount = Common::percentageDiscount();
            $fixedDiscount = Cart::tax();

            $this->sendEmail($order, $total, $price_total, $percentageDiscount, $fixedDiscount);

            //Xoa don hang
            Cart::destroy();

            //Tra ket qua thong bao
            return redirect('checkout/result')->with('notification', "Success! You will pay on delivery. Please check your email.");
        }
        
        if($request->payment_type == 'online_payment') {
            //Lay URL thanh toan VNPay
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id, //id don hang
                'vnp_OrderInfo' => 'Mo ta', //mo ta don hang
                'vnp_Amount' => Cart::total(0, '', '') * 24000, //tong gia don hang
            ]);
            //Chuyen huong toi URL lay duoc
        }   return redirect()->to($data_url);
    }

    public function result()
    {
        $notification = session('notification');
        return view('front.checkout.result', compact('notification'));
    }

    public function vnPayCheck(Request $request)
    {
        //Lay data tu URL (do VNPay gui ve qua $vnp_Returnurl)
        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); //Ma phan hoi ket qua thanh toan. 00 = Thanh cong
        $vnp_TxnRef = $request->get('vnp_TxnRef'); //order_id
        $vnp_Amount = $request->get('vnp_Amount'); //Tong tien thanh toan

        //Kiem tra data, xem ket qua giao dich ve tu VNPay hop le khong
        if($vnp_ResponseCode != null) {
            //Neu thanh cong
            if($vnp_ResponseCode == 00) {
                //Gui email
                $order = $this->orderService->find($vnp_TxnRef);
                $price_total = Cart::priceTotal();
                $total = Cart::total();
                $percentageDiscount = Common::percentageDiscount();
                $fixedDiscount = Cart::tax();

                $this->sendEmail($order, $total, $price_total, $percentageDiscount, $fixedDiscount);

                //Xoa gio hang
                Cart::destroy();

                //Thong bao ket qua
                return redirect('checkout/result')->with('notification', "Success! Has paid online. Please check your email.");
            }
            //Neu khong thanh cong
            else {
                //Xoa don hang da them vao DB
                $this->orderService->delete($vnp_TxnRef);

                //Thong bao loi
                return redirect('checkout/result')->with('notification', "ERROR: Payment failed or canceled");
            }
        }
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

    public function updateCoupon($coupon_code)
    {
        $coupon = Coupon::where('code', $coupon_code)->get();
        $coupon_amount = $coupon[0]->amount - 1;

        Coupon::where('code', $coupon_code)->update(['amount' => $coupon_amount]);
    }

    private function sendEmail($order, $total, $price_total, $percentageDiscount, $fixedDiscount) 
    {
        $email_to = $order->email;

        Mail::send('front.checkout.orderEmail',
                compact('order', 'total', 'price_total', 'percentageDiscount', 'fixedDiscount'),
                function ($message) use ($email_to) {
                    $message->from('codelean@gmail.com', "CodeLean eShop");
                    $message->to($email_to, $email_to);
                    $message->subject('Order Notification');
                });
    }
}

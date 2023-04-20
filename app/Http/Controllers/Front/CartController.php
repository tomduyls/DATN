<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Service\Product\ProductServiceInterface;
use App\Utilities\Common;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    // public function add(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $product = $this->productService->find($request->productId);

    //         $response['cart'] = Cart::add([
    //             'id' => $product->id,
    //             'name' => $product->name,
    //             'qty' => 1,
    //             'price' => $product->discount ?? $product->price,
    //             'weight' => $product->weight ?? 0,
    //             'options' => [
    //                 'images' => $product->productImages,
    //                 'size' => 'S',
    //             ], 
    //         ]);

    //         $response['count'] = Cart::count();
    //         $response['total'] = Cart::total();

    //         return $response;
    //     }

    //     return back();
    // }

    public function index()
    {
        $carts = Cart::content();
        $cart_key = $carts->keys();
        $total = Cart::total();
        $priceTotal = Cart::priceTotal();
        $percentageDiscount = Common::percentageDiscount();
        $fixedDiscount = Cart::tax();
        return view('front.shop.cart', compact('carts', 'total', 'priceTotal', 'percentageDiscount', 'fixedDiscount', 'cart_key'));
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $response['cart'] = Cart::remove($request->rowId);

            $response['count'] = Cart::count();
            $response['total'] = Cart::total();
            $response['price-total'] = Cart::subtotal();

            return $response;
        }

        return back();
    }

    public function destroy()
    {
        Cart::destroy();
    }

    public function update(Request $request)
    {
        if($request->ajax()) {
            $response['cart'] = Cart::update($request->rowId, $request->qty);

            $response['count'] = Cart::count();
            $response['total'] = Cart::total();
            $response['price-total'] = Cart::priceTotal();

            return $response;
        }
    }

    public function getCoupon(Request $request)
    {
        if($request->ajax()) {
            
            $coupon = Coupon::where('code', $request->code)->get();

            if($coupon[0]->amount <=0) {
                $response['error'] = "Code expired!";

                return $response;
            }
            else {
                //Luu code coupon => checkout update so luong coupon
                if($coupon->count() > 0) {
                    $cart_first_item = Cart::get($request->rowId);
                    $first_item_options = $cart_first_item->options->merge(['coupon' => $request->code]);
                    Cart::update($request->rowId, ['options' => $first_item_options]);
                }

                if($coupon[0]->type == 'percentage') {
                    Cart::setGlobalTax(0);
                    Cart::setGlobalDiscount($coupon[0]->value);
                    $response['percentage-discount'] = Common::percentageDiscount();
                }
                else {
                    Cart::setGlobalDiscount(0);
                    Cart::setGlobalTax($coupon[0]->value/Cart::count());
                    $response['fixed-discount'] = Cart::tax();
                }

                $response['price-total'] = Cart::priceTotal();
                $response['total'] = Cart::total();
                
                return $response;
            }
        }
    }

    public function removeCoupon(Request $request)
    {
        if($request->ajax()) {
            Cart::setGlobalTax(0);
            Cart::setGlobalDiscount(0);
            
            $cart_first_item = Cart::get($request->rowId);
            $first_item_options = $cart_first_item->options->merge(['coupon' => '']);
            Cart::update($request->rowId, ['options' => $first_item_options]);

            $response['total'] = Cart::total();
            
            return $response;
        }
    }

}

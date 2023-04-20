<?php

namespace App\Http\Controllers\Front;

use App\Service\Product\ProductServiceInterface;
use App\Service\ProductCategory\ProductCategoryServiceInterface;
use App\Service\Brand\BrandServiceInterface;
use App\Service\ProductComment\ProductCommentServiceInterface;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    private $productService;
    private $productCategoryService;
    private $brandService;
    private $productCommentService;

    public function __construct(ProductServiceInterface $productService, 
                                ProductCategoryServiceInterface $productCategoryService,
                                BrandServiceInterface $brandService,
                                ProductCommentServiceInterface $productCommentService)
    {
        $this->productService = $productService;
        $this->productCategoryService = $productCategoryService;
        $this->brandService = $brandService;
        $this->productCommentService = $productCommentService;
    }

    public function show($id)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $product = $this->productService->find($id);
        $relatedProduct = $this->productService->getRelatedProducts($product);

        return view('front.shop.show', compact('product', 'relatedProduct', 'categories', 'brands'));
    }

    public function addCart(Request $request) 
    {
        $product = $this->productService->find($request->id);
        Cart::add([
            'id' => $request->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->discount ?? $product->price,
            'weight' => $product->weight ?? 0,
            'options' => [
                'images' => $product->productImages,
                'size' => $request->size,
                'coupon' => '',
            ]
        ]);

        return redirect()->back();
    }

    public function postComment(Request $request) 
    {   
        $this->productCommentService->create($request->all());
    }

    public function loadComment(Request $request)
    {
        $product = $this->productService->find($request->product_id);
        $response = '';
        foreach($product->productComments as $comment) {
            $comment_date = date('M d, Y', strtotime($comment->created_at));
            $comment_avatar = $comment->user->avatar ?? 'default-avatar.jpg';
            $response .= '<div class="co-item">
                        <div class="avatar-pic"> 
                        <img src="front/img/user/'.$comment_avatar.'" alt="">
                        </div>
                        <div class="avatar-text">
                        <h5>'.$comment->name.' <span>'.$comment_date.'</span></h5>';
            if ($comment->checked == 0)
                $response .= 'This comment is being checked.</div></div>';   
            else {
                $response .= '<div class="at-rating">';
                for($i = 1; $i <= 5; $i++) {
                    if($i <= $comment->rating)
                        $response .= '<i class="fa fa-star"></i> ';
                    else $response .= '<i class="fa fa-star-o"></i> ';
                }
                $response .= '</div> <p>'.$comment->messages.'</p></div></div>';
            }
        }    
        echo $response;        
    }

    public function index(Request $request)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $products = $this->productService->getProductOnIndex($request);
        

        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }

    public function category($categoryName, Request $request)
    {
        $categories = $this->productCategoryService->all();
        $brands = $this->brandService->all();
        $products = $this->productService->getProductByCategory($categoryName, $request);

        return view('front.shop.index', compact('products', 'categories', 'brands'));
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Service\Product\ProductServiceInterface;
use App\Service\ProductCategory\ProductCategoryServiceInterface;
use App\Service\Brand\BrandServiceInterface;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class ShopController extends Controller
{
    private $productService;
    private $productCategoryService;
    private $brandService;

    public function __construct(ProductServiceInterface $productService, 
                                ProductCategoryServiceInterface $productCategoryService,
                                BrandServiceInterface $brandService)
    {
        $this->productService = $productService;
        $this->productCategoryService = $productCategoryService;
        $this->brandService = $brandService;
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
            ]
        ]);

        return redirect()->back();
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

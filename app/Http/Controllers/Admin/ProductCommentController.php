<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use App\Service\Product\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product_id)
    {
        $product = $this->productService->find($product_id);
        $productComments = $product->productComments;

        return view('admin.product.comment.index', compact('product', 'productComments'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($product_id, $product_comment_id)
    {
        $product = $this->productService->find($product_id);
        $productComment = ProductComment::find($product_comment_id);

        return view('admin.product.comment.edit', compact('product', 'productComment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id, $product_comment_id)
    {
        $data = $request->all();
        if($request->checked == null)
            $data += ['checked' => 0];

        ProductComment::find($product_comment_id)->update($data);
        
        return redirect('/admin/product/' . $product_id . '/comment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $product_comment_id)
    {
        ProductComment::find($product_comment_id)->delete();

        return redirect('/admin/product/' . $product_id . '/comment');
    }
}

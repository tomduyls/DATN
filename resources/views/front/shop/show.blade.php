@extends('front.layout.master')

@section('title', 'Product')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.html"><i class="fa fa-home"> Home</i></a>
                        <a href="shop.html"> Home</a>
                        <span>Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Product Shop Section Begin -->
    <section class="product-shop spad page-details"> 
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('front.shop.components.products-sidebar-filter')
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="front/img/products/{{ $product->productImages[0]->path ?? '' }}" alt="">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    @foreach ($product->productImages as $item)
                                        <div class="pt active" data-imgbigurl="front/img/products/{{ $item->path }}">
                                            <img src="front/img/products/{{ $item->path }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <form action="" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $product->id }}">
                                    <div class="pd-title">
                                        <span>{{ $product->tag }}</span>
                                        <h3>{{ $product->name }}</h3>
                                    </div>
                                    <div class="pd-desc">
                                        <p>{{ $product->content }}</p>
                                        @if ( $product->discount != null)
                                            <h4>${{ $product->discount }} <span>{{ $product->price }}</span></h4>
                                        @else
                                            <h4>${{ $product->price }}</h4>
                                        @endif
                                        
                                    </div>
                                    
                                    <div class="pd-size-choose">
                                        {{-- @foreach (array_unique(array_column($product->productDetails->toArray(), 'size')) as $size) --}}
                                        @foreach ($product->productDetails as $productDetail)
                                                <div class="form-check form-check-inline">
                                                    <input required class="form-check-input" type="radio" name="size" id="xl-{{ $productDetail->size }}" value="{{ $productDetail->size }}" {{ $productDetail->qty <= 0 ? 'disabled' : ''}}>
                                                    <label class="form-check-label" for="xl-{{ $productDetail->size }}" {{ $productDetail->qty <= 0 ? 'disabled' : ''}}>{{ $productDetail->size }} </label>
                                                </div> 
                                                {{-- <p>{{$productDetail->qty}} products available</p> --}}
                                        @endforeach
                                    </div>
                                    <div class="quantity">
                                        @if (array_sum(array_column($product->productDetails->toArray(), 'qty')) > 0)
                                        <div class="pro-qty">
                                            <input type="number" name="qty" value="1" min="1" max="5">
                                        </div>
                                            <button type="submit" class="primary-btn pd-cart" >Add To Cart</button> 
                                        @else <h3>Out of Stock</h3>
                                        @endif 
                                    
                                </form>
                                    {{-- <a href="#" class="primary-btn pd-cart">Add To Cart</a> --}}
                                </div>
                                <ul class="pd-tags">
                                    <li><span>CATEGORIES</span>: {{ $product->productCategory->name }}</li>
                                    <li><span>TAGS</span>: {{ $product->tag }}</li>
                                </ul>
                                <div class="pd-share">
                                    <div class="p-code">Sku: {{ $product->sku }}</div>
                                    <div class="pd-social">
                                        <a href="#"><i class="ti-facebook"></i></a>
                                        <a href="#"><i class="ti-twitter-alt"></i></a>
                                        <a href="#"><i class="ti-linkedin"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li><a class="active" href="#tab-1" data-toggle="tab" role="tab">DESCRIPTION</a></li>
                                <li><a href="#tab-2" data-toggle="tab" role="tab">SPECIFICATIONS</a></li>
                                {{-- <li><a href="#tab-3" data-toggle="tab" role="tab">Customer Reviews ({{ count($product->productComments)}})</a></li> --}}
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="product-content">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                    <div class="p-price">
                                                        ${{ $product->price }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Add to Cart</td>
                                                <td>
                                                    <div class="cart-add">+ add to cart</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Acailability</td>
                                                <td>
                                                    <div class="p-stock">{{ $product->qty }} in stock</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Weight</td>
                                                <td>
                                                    <div class="p-weight">{{ $product->weight }}kg</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Size</td>
                                                <td>
                                                    <div class="p-size">
                                                        @foreach (array_unique(array_column($product->productDetails->toArray(), 'size')) as $item)
                                                            {{ $item }}
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="p-catagory">Sku</td>
                                                <td>
                                                    <div class="p-code">{{ $product->sku }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </section>
    <!-- Product Shop Section End -->

    <!-- Related Products Section Begin -->
    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedProduct as $item)
                    <div class="col-lg-3 col-sm-6">
                        @include('front.components.product-item')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Related Products Section End -->
@endsection
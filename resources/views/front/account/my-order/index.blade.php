@extends('front.layout.master')

@section('title', 'My Order')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./"><i class="fa fa-home"></i> Home</a>
                        <span>My Order</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <div class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Id</th>
                                    <th>Products</th>
                                    <th>Total</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="cart-pic first-form">
                                            <img src="front/img/products/{{ $order->orderDetails[0]->product->productImages[0]->path }}" alt="">
                                        </td>
                                        <td class="first-row">{{ $order->id }}</td>
                                        <td class="cart-title first-row text-center">
                                            <h5>{{ $order->orderDetails[0]->product->name }}
                                                @if (count($order->orderDetails) > 1)
                                                    and {{ count($order->orderDetails) }} other products</h5>
                                                @endif 
                                        </td>
                                        <td class="total-price first-row">
                                            @if ($order->coupon_type == "fixed")
                                                ${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) - $order->coupon_value }}
                                            @elseif ($order->coupon_type == "percentage")
                                                ${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) * $order->coupon_value/100 }}
                                            @else
                                                ${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) }}
                                            @endif
                                        </td>
                                        <td class="first-row">
                                            <a href="./account/my-order/{{ $order->id }}" class="btn">Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
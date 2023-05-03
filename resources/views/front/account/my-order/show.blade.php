@extends('front.layout.master')

@section('title', 'Order Detail')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./"><i class="fa fa-home"></i> Home</a>
                        <a href="./my-order"><i class="fa fa-home"></i>My Order</a>
                        <span>Order Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <div class="checkout-section spad">
        <div class="container">
            <form action="#" class="checkout-form">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a href="#" class="content-btn">Order ID: <b>{{ $order->id }}</b></a>
                        </div>
                        <h4>Billing Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="fir">First Name</label>
                                <input disabled type="text" id="fir" value="{{ $order->first_name }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Last Name</label>
                                <input disabled type="text" id="last" value="{{ $order->last_name }}">
                            </div>
                            {{-- <div class="col-lg-12">
                                <label for="cun-name">Company Name</label>
                                <input disabled type="text" id="cun-name" value="{{ $order->company_name }}">
                            </div> --}}
                            <div class="col-lg-12">
                                <label for="cun">Country</label>
                                <input disabled type="text" id="cun" value="{{ $order->country }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="street">Street Address</label>
                                <input disabled type="text" id="street" class="stress-first" value="{{ $order->street_address }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="zip">Postcode / ZIP (optional)</label>
                                <input disabled type="text" id="zip" value="{{ $order->postcode_zip }}">
                            </div>
                            <div class="col-lg-12">
                                <label for="town">Town / City</label>
                                <input disabled type="text" id="town" value="{{ $order->town_city }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Address</label>
                                <input disabled type="text" id="email" value="{{ $order->email }}">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone</label>
                                <input disabled type="text" id="phone" value="{{ $order->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a href="#" class="content-btn">
                                Status:
                                <b>{{ \App\Utilities\Constant::$order_status[$order->status] }}</b>
                            </a>
                        </div>
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>
                                    @foreach ($order->orderDetails as $orderDetail)
                                        <li class="fw-normal">
                                            {{ $orderDetail->product->name }} {{ $orderDetail->size }} x {{ $orderDetail->qty }} 
                                            <span>${{ $orderDetail->total }}</span>
                                        </li>
                                    @endforeach
                                    <li class="fw-normal">Discount <span>@if ($order->coupon_type == "fixed")
                                                                            ${{ $order->coupon_value }}
                                                                        @elseif ($order->coupon_type == "percentage")
                                                                            {{ $order->coupon_value }}%
                                                                        @else
                                                                        @endif
                                                                    </span>
                                    </li>
                                    <li class="total-price">
                                        Total 
                                        <span>
                                            @if ($order->coupon_type == "fixed")
                                                ${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) - $order->coupon_value }}
                                            @elseif ($order->coupon_type == "percentage")
                                                ${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) * $order->coupon_value/100 }}
                                            @else
                                                ${{ array_sum(array_column($order->orderDetails->toArray(), 'total')) }}
                                            @endif
                                    </span>
                                    </li>
                                </ul>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-check">
                                            Pay later
                                            <input disabled type="radio" id="pc-check" name="payment_type" value="pay_later"
                                                    {{ $order->payment_type == 'pay_later' ? 'checked' : ''}}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-paypal">
                                            Online payment
                                            <input disabled type="radio" id="pc-paypal" name="payment_type" value="online_payment"
                                                    {{ $order->payment_type == 'online_payment' ? 'checked' : ''}}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Shopping Cart Section End -->
@endsection
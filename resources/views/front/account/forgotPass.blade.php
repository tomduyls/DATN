@extends('front.layout.master')

@section('title', 'Forgot Password')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.html"><i class="fa fa-home"> Home</i></a>
                        <span>Forgot Password</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Login Section Begin -->
    <div class="register-login-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="login-form">
                        <h2>Forgot password</h2>
                        @if (session('notification'))
                            <div class="alert alert-warning" role="alert">{{ session('notification') }}</div>
                        @endif
                        <form action="" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="email">Email address *</label>
                                <input type="email" id="email" name="email">
                                @error('email')
                                    <span style="color:red;"> {{$message}}</span>
                                @enderror
                            </div>
                            <button type="submit" class="site-btn login-btn">Send email</button>
                        </form>
                        <div class="switch-login">
                            <a href="./account/login" class="or-login">Or Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Section End -->
@endsection
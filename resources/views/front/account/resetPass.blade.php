@extends('front.layout.master')

@section('title', 'Reset Password')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./"><i class="fa fa-home"></i> Home</a>
                        <span>Reset Password</span>
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
                        <h2>Reset Password</h2>
                        @if (session('notification'))
                            <div class="alert alert-warning" role="alert">{{ session('notification') }}</div>
                        @endif
                        <form action="" method="POST">
                            @csrf
                            <div class="group-input">
                                <label for="pass">Password *</label>
                                <input type="password" id="pass" name="password">
                                @error('password')
                                    <span style="color:red;"> {{$message}}</span>
                                @enderror
                            </div>
                            <div class="group-input">
                                <label for="con-pass">Confirm Password *</label>
                                <input type="password" id="con-pass" name="password_confirmation">
                                @error('password_confirmation')
                                    <span style="color:red;"> {{$message}}</span>
                                @enderror
                            </div>
                            <button type="submit" class="site-btn login-btn">Reset password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Section End -->
@endsection
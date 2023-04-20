@extends('front.layout.master')

@section('title', 'My Account')

@section('body')
    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./"><i class="fa fa-home"></i> Home</a>
                        <span>My Account</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                @include('admin.components.notification')
                <div class="card-body display_data">
                    <div class="position-relative row form-group">
                        <label for="image" class="col-md-3 text-md-right col-form-label">Avatar</label>
                        <div class="col-md-9 col-xl-8">
                            <p>
                                <img style="height: 200px;" class="rounded-circle" data-toggle="tooltip"
                                    title="Avatar" data-placement="bottom"
                                    src="/front/img/user/{{ $user->avatar ?? 'default-avatar.jpg' }}" alt="Avatar">
                            </p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="name" class="col-md-3 text-md-right col-form-label">
                            Name
                        </label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="email" class="col-md-3 text-md-right col-form-label">Email</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="company_name" class="col-md-3 text-md-right col-form-label">
                            Company Name
                        </label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->company_name }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="country"
                            class="col-md-3 text-md-right col-form-label">Country</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->country }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="street_address" class="col-md-3 text-md-right col-form-label">
                            Street Address</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->street_address }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="postcode_zip" class="col-md-3 text-md-right col-form-label">
                            Postcode Zip</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->postcode_zip }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="town_city" class="col-md-3 text-md-right col-form-label">
                            Town City</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->town_city }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="phone" class="col-md-3 text-md-right col-form-label">Phone</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->phone }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="description"
                            class="col-md-3 text-md-right col-form-label">Description</label>
                        <div class="col-md-9 col-xl-8">
                            <p>{{ $user->description }}</p>
                        </div>
                    </div>

                    <div class="position-relative row form-group">
                        <label for="description"
                            class="col-md-3 text-md-right col-form-label">
                                <a href="/account/my-account/edit" class="btn btn-primary">
                                    <span><i class="fa fa-edit fa-w-20"></i></span>
                                    <span>Edit</span>
                                </a>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('admin.layout.master')

@section('title', 'Coupon')

@section('body')
                <!-- Main -->
                <div class="app-main__inner">

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                                </div>
                                <div>
                                    Coupon
                                    <div class="page-title-subheading">
                                        View, create, update, delete and manage.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form method="post" action="/admin/coupon" enctype="multipart/form-data">
                                        @csrf
                                        <div class="position-relative row form-group">
                                            <label for="name" class="col-md-3 text-md-right col-form-label">Name</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input required name="name" id="name" placeholder="Name" type="text"
                                                    class="form-control" value="{{ old('name') ?? '' }}">
                                            </div>
                                            @error('name')
                                                <div class="col-md-3 text-md-right col-form-label"></div>
                                                <div class="col-md-9 col-xl-8" style="color:red;"> {{$message}}</div>
                                            @enderror
                                        </div>

                                        <div class="position-relative row form-group">
                                            <label for="type" class="col-md-3 text-md-right col-form-label">Type</label>
                                            <div class="col-md-9 col-xl-8">
                                                <select required name="type" id="type" class="form-control">
                                                    <option value="">-- Type --</option>
                                                    <option {{ old('type') == 'fixed' ? "selected" : ''}} value="fixed">Fixed</option>
                                                    <option {{ old('type') == 'percentage' ? "selected" : ''}} value="percentage">Percentage</option>
                                                </select>
                                            </div>
                                            @error('type')
                                                <div class="col-md-3 text-md-right col-form-label"></div>
                                                <div class="col-md-9 col-xl-8" style="color:red;"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        

                                        <div class="position-relative row form-group">
                                            <label for="amount" class="col-md-3 text-md-right col-form-label">Amount</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input required name="amount" id="amount" placeholder="Amount" type="text"
                                                    class="form-control" value="{{ old('amount') ?? '' }}">
                                            </div>
                                            @error('amount')
                                                <div class="col-md-3 text-md-right col-form-label"></div>
                                                <div class="col-md-9 col-xl-8" style="color:red;"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        

                                        <div class="position-relative row form-group">
                                            <label for="value" class="col-md-3 text-md-right col-form-label">Value</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input required name="value" id="value" placeholder="Value" type="value"
                                                    class="form-control" value="{{ old('value') ?? '' }}">
                                            </div>
                                            @error('value')
                                                <div class="col-md-3 text-md-right col-form-label"></div>
                                                <div class="col-md-9 col-xl-8" style="color:red;"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        

                                        <div class="position-relative row form-group">
                                            <label for="code" class="col-md-3 text-md-right col-form-label">Code</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input required name="code" id="code" placeholder="Code" type="code"
                                                    class="form-control" value="{{ old('code') ?? '' }}">
                                            </div>
                                            @error('code')
                                                <div class="col-md-3 text-md-right col-form-label"></div>
                                                <div class="col-md-9 col-xl-8" style="color:red;"> {{$message}}</div>
                                            @enderror
                                        </div>
                                        

                                        <div class="position-relative row form-group mb-1">
                                            <div class="col-md-9 col-xl-8 offset-md-2">
                                                <a href="/admin/coupon" class="border-0 btn btn-outline-danger mr-1">
                                                    <span class="btn-icon-wrapper pr-1 opacity-8">
                                                        <i class="fa fa-times fa-w-20"></i>
                                                    </span>
                                                    <span>Cancel</span>
                                                </a>

                                                <button type="submit"
                                                    class="btn-shadow btn-hover-shine btn btn-primary">
                                                    <span class="btn-icon-wrapper pr-2 opacity-8">
                                                        <i class="fa fa-download fa-w-20"></i>
                                                    </span>
                                                    <span>Save</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Main -->
@endsection
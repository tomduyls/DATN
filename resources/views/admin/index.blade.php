@extends('admin.layout.master')

@section('title', 'Dashboard')

@section('body')
<div class="container-fluid">
    <div class="grid-menu grid-menu-xl grid-menu-3col mt-2">
        <div class="no-gutters row stats">
            <div class="col-sm-6 col-xl-3">
                <a href="./order" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                    <i class="pe-7s-cart icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3"></i>
                    <b>{{ $newOrders }}</b> New Orders
                </a>
            </div>
            <div class="col-sm-6 col-xl-3">
                <a href="./user" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                    <i class="pe-7s-users icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3">
                    </i> 
                    <b>{{ $users }}</b> Users
                </a>
            </div>
            <div class="col-sm-6 col-xl-3">
                <a href="./coupon" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                    <i class="pe-7s-ticket icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3">
                    </i> 
                    <b>{{ $coupons }}</b> Coupons
                </a>
            </div>
            <div class="col-sm-6 col-xl-3">
                <a href="./blog" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                    <i class="pe-7s-news-paper icon-gradient bg-night-fade btn-icon-wrapper btn-icon-lg mb-3">
                    </i> 
                    <b>{{ $blogs }}</b> Blogs
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <b>Sales chart:</b>
            <canvas id="myChart" class="sale-chart"></canvas>
        </div>
    </div> 

</div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var orderChart = new Chart(ctx, {
        type:'bar',
        data:{
            labels: {!! json_encode($labels) !!},
            datasets: {!! json_encode($datasets) !!}
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, // starts the y-axis at zero
                    suggestedMin: 0, // sets the minimum value for y-axis
                    suggestedMax: 10, // sets the maximum value for y-axis
                }
            }
        }
    });
  </script>
@endsection
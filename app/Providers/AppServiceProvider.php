<?php

namespace App\Providers;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Service\Product\ProductServiceInterface;
use App\Service\Product\ProductService;

use App\Repositories\ProductComment\ProductCommentRepository;
use App\Repositories\ProductComment\ProductCommentRepositoryInterface;
use App\Service\ProductComment\ProductCommentServiceInterface;
use App\Service\ProductComment\ProductCommentService;

use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Service\ProductCategory\ProductCategoryServiceInterface;
use App\Service\ProductCategory\ProductCategoryService;

use App\Repositories\Blog\BlogRepository;
use App\Repositories\Blog\BlogRepositoryInterface;
use App\Service\Blog\BlogServiceInterface;
use App\Service\Blog\BlogService;

use App\Repositories\BlogComment\BlogCommentRepository;
use App\Repositories\BlogComment\BlogCommentRepositoryInterface;
use App\Service\BlogComment\BlogCommentServiceInterface;
use App\Service\BlogComment\BlogCommentService;

use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Service\Coupon\CouponServiceInterface;
use App\Service\Coupon\CouponService;

use App\Repositories\Brand\BrandRepository;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Service\Brand\BrandServiceInterface;
use App\Service\Brand\BrandService;

use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Service\Order\OrderServiceInterface;
use App\Service\Order\OrderService;

use App\Repositories\OrderDetail\OrderDetailRepository;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use App\Service\OrderDetail\OrderDetailServiceInterface;
use App\Service\OrderDetail\OrderDetailService;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Service\User\UserServiceInterface;
use App\Service\User\UserService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Product
        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->singleton(
            ProductServiceInterface::class,
            ProductService::class
        );

        //ProductComment
        $this->app->singleton(
            ProductCommentRepositoryInterface::class,
            ProductCommentRepository::class
        );

        $this->app->singleton(
            ProductCommentServiceInterface::class,
            ProductCommentService::class
        );

        //ProductCategory
        $this->app->singleton(
            ProductCategoryRepositoryInterface::class,
            ProductCategoryRepository::class
        );

        $this->app->singleton(
            ProductCategoryServiceInterface::class,
            ProductCategoryService::class
        );

        //Blog
        $this->app->singleton(
            BlogRepositoryInterface::class,
            BlogRepository::class
        );

        $this->app->singleton(
            BlogServiceInterface::class,
            BlogService::class
        );

        //BlogComment
        $this->app->singleton(
            BlogCommentRepositoryInterface::class,
            BlogCommentRepository::class
        );

        $this->app->singleton(
            BlogCommentServiceInterface::class,
            BlogCommentService::class
        );

        //Coupon
        $this->app->singleton(
            CouponRepositoryInterface::class,
            CouponRepository::class
        );

        $this->app->singleton(
            CouponServiceInterface::class,
            CouponService::class
        );

        //Brand
        $this->app->singleton(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->singleton(
            BrandServiceInterface::class,
            BrandService::class
        );

        //Order
        $this->app->singleton(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->singleton(
            OrderServiceInterface::class,
            OrderService::class
        );

        //OrderDetail
        $this->app->singleton(
            OrderDetailRepositoryInterface::class,
            OrderDetailRepository::class
        );

        $this->app->singleton(
            OrderDetailServiceInterface::class,
            OrderDetailService::class
        );

        //User
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->singleton(
            UserServiceInterface::class,
            UserService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Repositories\BaseRepositories;

class CouponRepository extends BaseRepositories implements CouponRepositoryInterface
{
    public function getModel()
    {
        return Coupon::class;
    }
}
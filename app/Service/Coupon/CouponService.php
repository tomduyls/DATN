<?php

namespace App\Service\Coupon;

use App\Service\BaseService;
use App\Repositories\Coupon\CouponRepositoryInterface;

class CouponService extends BaseService implements CouponServiceInterface
{
    public $repository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->repository = $couponRepository;
    }
}
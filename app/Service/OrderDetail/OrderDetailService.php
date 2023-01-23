<?php

namespace App\Service\OrderDetail;

use App\Service\BaseService;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;

class OrderDetailService extends BaseService implements OrderDetailServiceInterface
{
    public $repository;

    public function __construct(OrderDetailRepositoryInterface $orderDetailRepository)
    {
        $this->repository = $orderDetailRepository;
    }
}
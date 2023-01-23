<?php

namespace App\Service\ProductCategory;

use App\Service\BaseService;
use App\Repositories\ProductCategory\ProductCategoryRepositoryInterface;

class ProductCategoryService extends BaseService implements ProductCategoryServiceInterface
{
    public $repository;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
    {
        $this->repository = $productCategoryRepository;
    }
}
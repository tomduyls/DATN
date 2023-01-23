<?php

namespace App\Service\Product;

use App\Service\BaseService;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
    public $repository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->repository = $productRepository;
    }

    public function find(int $id)
    {
        $product = $this->repository->find($id);

        return $product;
    }

    public function getRelatedProducts($product, $limit = 4)
    {
        return $this->repository->getRelatedProducts($product, $limit);
    }

    public function getFeaturedProducts()
    {
        return [
            "men" => $this->repository->getFeaturedProductsByCategory(1),
            "women" => $this->repository->getFeaturedProductsByCategory(2),
        ];
    }

    public function getProductOnIndex($request)
    {
        return $this->repository->getProductOnIndex($request);
    }

    public function getProductByCategory($categoryName, $request)
    {
        return $this->repository->getProductByCategory($categoryName, $request);
    }
}
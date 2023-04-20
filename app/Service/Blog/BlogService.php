<?php

namespace App\Service\Blog;

use App\Service\BaseService;
use App\Repositories\Blog\BlogRepositoryInterface;

class BlogService extends BaseService implements BlogServiceInterface
{
    public $repository;

    public function __construct(BlogRepositoryInterface $blogRepository)
    {
        $this->repository = $blogRepository;
    }

    public function getLatestBlogs($limit = 3)
    {
        return $this->repository->getLatestBlogs($limit);
    }

    public function getRelatedBlogs($blog, $limit = 2)
    {
        return $this->repository->getRelatedBlogs($blog, $limit);
    }

    public function getBlogOnIndex($request)
    {
        return $this->repository->getBlogOnIndex($request);
    }

    public function getBlogByCategory($categoryName, $request)
    {
        return $this->repository->getBlogByCategory($categoryName, $request);
    }
}
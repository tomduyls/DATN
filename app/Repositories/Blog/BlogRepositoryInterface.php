<?php

namespace App\Repositories\Blog;

use App\Repositories\RepositoriesInterface;

interface BlogRepositoryInterface extends RepositoriesInterface
{
    public function getLatestBlogs($limit = 3);
    public function getRelatedBlogs($blog, $limit = 2);
    public function getBlogOnIndex($request);
    public function getBlogByCategory($categoryName, $request);
}
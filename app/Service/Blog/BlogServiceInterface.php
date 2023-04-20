<?php

namespace App\Service\Blog;

use App\Service\ServiceInterface;

interface BlogServiceInterface extends ServiceInterface
{
    public function getLatestBlogs($limit = 3);
    public function getRelatedBlogs($blog, $limit = 2);
    public function getBlogOnIndex($request);
    public function getBlogByCategory($categoryName, $request);
}
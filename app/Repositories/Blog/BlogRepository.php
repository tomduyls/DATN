<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Repositories\BaseRepositories;

class BlogRepository extends BaseRepositories implements BlogRepositoryInterface
{
    public function getModel()
    {
        return Blog::class;
    }

    public function getLatestBlogs($limit = 3)
    {
        return $this->model->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getRelatedBlogs($blog, $limit = 2) 
    {
        return $this->model->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->limit($limit)
            ->get();
    }

    public function getBlogOnIndex($request)
    {
        $search = $request->search ?? '';

        $blogs = $this->model->where('title', 'like', '%'.$search.'%');

        $blogs = $this->sortAndPagination($blogs, $request);
        
        return $blogs;
    }

    public function getBlogByCategory($categoryName, $request)
    {
        $blogs = Blog::where('category', $categoryName)->get()->toQuery();
        $blogs = $this->sortAndPagination($blogs, $request);

        return $blogs;
    }

    private function sortAndPagination($blogs, $request)
    {
        $perPage = $request->show ?? 4;
        $sortBy = $request->sort_by ?? 'latest';

        switch ($sortBy) {
            case 'latest':
                $blogs = $blogs->orderBy('id');
                break;
            case 'oldest':
                $blogs = $blogs->orderByDesc('id');
                break;
        }

        $blogs = $blogs->paginate($perPage);

        $blogs->appends(['sort_by' => $sortBy, 'show' => $perPage]);
        return $blogs;
    }
}
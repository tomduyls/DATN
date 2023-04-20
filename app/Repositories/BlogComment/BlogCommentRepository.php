<?php

namespace App\Repositories\BlogComment;

use App\Models\BlogComment;
use App\Repositories\BaseRepositories;

class BlogCommentRepository extends BaseRepositories implements BlogCommentRepositoryInterface
{
    public function getModel()
    {
        return BlogComment::class;
    }
}
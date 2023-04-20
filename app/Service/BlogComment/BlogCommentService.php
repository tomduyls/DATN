<?php

namespace App\Service\BlogComment;

use App\Service\BaseService;
use App\Repositories\BlogComment\BlogCommentRepositoryInterface;

class BlogCommentService extends BaseService implements BlogCommentServiceInterface
{
    public $repository;

    public function __construct(BlogCommentRepositoryInterface $BlogCommentRepository)
    {
        $this->repository = $BlogCommentRepository;
    }
}
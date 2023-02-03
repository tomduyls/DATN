<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepositories;

class UserRepository extends BaseRepositories implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUserByEmail($email)
    {
        return $this->model
                ->where('email', $email)
                ->get();
    }
}
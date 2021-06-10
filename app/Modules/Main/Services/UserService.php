<?php

namespace App\Modules\Main\Services;

use App\Models\User;
use orkester\MVC\MService;
use App\Repositories\ORM\UserRepository;

class UserService extends MService
{

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOrCreateUserByAuth0(string $auth0, string $name = ''): User
    {
        $user = $this->repository->getUserByAuth0($auth0);
        if (!isset($user->idUser)) {
            $user = $this->repository->createUser($auth0, $name);
        }
        return $user;
    }

}
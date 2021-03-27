<?php

namespace App\Modules\Main\Services;

use App\Models\User;
use Orkester\MVC\MService;
use App\Repositories\ORM\UserRepository;

class LoginService extends MService
{

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOrCreateUserByAuth0(object $userData): User
    {
        $auth0 = $userData->sub;
        $user = $this->repository->getUserByAuth0($auth0);
        mdump($user);
        if ($user->idUser === 0) {
            $user = $this->repository->createUser($userData);
            mdump($user);
        }
        return $user;
    }

}
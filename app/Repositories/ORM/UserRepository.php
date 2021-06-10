<?php

namespace App\Repositories\ORM;

use App\Models\User;
use Orkester\MVC\MRepositoryORM;

class UserRepository extends MRepositoryORM
{
    public function __construct() {
        parent::__construct('fnbr');
    }

    public function getUserByAuth0(string $auth0)
    {
        $criteria = $this->getCriteria(User::class)
            ->where("auth0IdUser = :auth0");
        return $this->retrieveFromCriteria(User::class, $criteria, ['auth0' => $auth0]);
    }

    public function createUser(object $userData): User
    {
        $data = (object)[
            'name' => $userData->name,
            'auth0IdUser' => $userData->sub,
            'nick' => $userData->nickname,
            'email' => $userData->email,
            'login' => $userData->email,
        ];
        $user = new User($data);
        $this->save($user);
        return $user;
    }

}

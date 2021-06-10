<?php

namespace App\Models;

use Orkester\MVC\MModel;
use Orkester\Types\MTimestamp;

class User extends MModel
{

    public ?int $idUser = 0;
    public ?string $login = '';
    public ?int $active = 0;
    public ?string $status = '';
    public ?string $name = '';
    public ?string $email = '';
    public ?string $nick = '';
    public ?string $auth0IdUser = '';
    public ?string $auth0CreatedAt = '';
    public ?MTimestamp $lastLogin = null;

    public static array $ORMMap = [
        'database' => 'fnbr',
        'table' => 'auth_user',
        'attributes' => [
            'idUser' => ['column' => 'idUser', 'type' => 'int', 'key' => 'primary', 'idgenerator' => 'identity'],
            'login' => ['column' => 'login', 'type' => 'string'],
            'active' => ['column' => 'active', 'type' => 'int'],
            'status' => ['column' => 'status', 'type' => 'string'],
            'name' => ['column' => 'name', 'type' => 'string'],
            'email' => ['column' => 'email', 'type' => 'string'],
            'nick' => ['column' => 'nick', 'type' => 'string'],
            'auth0IdUser' => ['column' => 'auth0IdUser', 'type' => 'string'],
            'auth0CreatedAt' => ['column' => 'auth0CreatedAt', 'type' => 'string'],
            'lastLogin' => ['column' => 'lastLogin', 'type' => 'MTimestamp'],
        ],
        'associations' => [
        ]
    ];

    public static array $config = [
        'log' => [],
        'validators' => [],
        'converters' => []
    ];

}

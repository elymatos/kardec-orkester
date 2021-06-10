<?php
return [
    'db' => [
        'kardec' => [
            'driver' => 'pdo_mysql',
            'host' => 'host.docker.internal',
            'dbname' => '',
            'user' => '',
            'password' => '',
            'formatDate' => '%e/%m/%Y',
            'formatDateWhere' => '%Y/%m/%e',
            'formatTime' => '%T',
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_bin',
            'sequence' => [
                'table' => 'Sequence',
                'name' => 'Name',
                'value' => 'Value'
            ],
            'configurationClass' => 'Doctrine\DBAL\Configuration',
        ],
        'kardec-cli' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => '',
            'user' => '',
            'password' => '',
            'formatDate' => '%e/%m/%Y',
            'formatDateWhere' => '%Y/%m/%e',
            'formatTime' => '%T',
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_bin',
            'sequence' => [
                'table' => 'Sequence',
                'name' => 'Name',
                'value' => 'Value'
            ],
            'configurationClass' => 'Doctrine\DBAL\Configuration',
        ],
    ],
];

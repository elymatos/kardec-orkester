<?php
declare(strict_types=1);

use Orkester\Middleware\LoginMiddleware;
use Orkester\Middleware\SessionMiddleware;
use Orkester\Middleware\DataMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(DataMiddleware::class);
    $app->add(LoginMiddleware::class);
    $app->add(SessionMiddleware::class);
};

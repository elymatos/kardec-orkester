<?php
declare(strict_types=1);

use App\Modules\Main\Controllers\LoginController;
use Orkester\MVC\MActionController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    //$app->group('/api', function (Group $group) use ($app) {
    //    $group->post('/auth0User', LoginController::class);//->add(new Auth0Middleware());
    //});

    $app->get('/api/{module}/{controller}/{action}[/{id}]',MActionController::class);
    $app->post('/api/{module}/{controller}/{action}[/{id}]',MActionController::class);
};

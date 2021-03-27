<?php

namespace App\Modules\Main\Controllers;

use Orkester\Exception\AuthException;
use App\Modules\Main\Services\LoginService;
use Orkester\Manager;
use Orkester\MVC\MAPIController;

class LoginController extends MAPIController
{

    private LoginService $loginService;

    public function __construct(LoginService $service)
    {
        parent::__construct();
        mdump('in construct LoginController');
        mdump(isset($service) ? 'service set' : 'service not set');
        $this->loginService = $service;//Manager::getService(LoginService::class);
    }

    public function auth0User()
    {
        try {
            $user = $this->loginService->getOrCreateUserByAuth0($this->data);
            Manager::getAuth()->registerLogin($user);
            mdump('===============');
            mdump($user);
            $this->renderObject($user);
        } catch (AuthException $e) {
            $this->renderResponse('error', $e->getMessage(), 401);
        } catch (\Exception $e) {
            $this->renderResponse('error', $e->getMessage(), 500);
        }
    }

}


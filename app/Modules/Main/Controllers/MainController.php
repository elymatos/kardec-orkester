<?php
namespace App\Modules\Main\Controllers;

use Orkester\MVC\MController;

class MainController extends MController
{
    public function main()
    {
        $result = (object)[
            'result' => 'Hello!'
        ];
        return $this->renderObject($result);
    }

}


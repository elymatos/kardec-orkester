<?php
namespace App\Modules\Main\Controllers;

use App\Modules\Main\Services\OmekaService;
use Orkester\Manager;
use Orkester\MVC\MController;

class OmekaController extends MController
{
    public function main()
    {
        $result = (object)[
            'result' => 'Omeka!'
        ];
        return $this->renderObject($result);
    }

    public function item() {
        $omekaService =  Manager::getContainer()->get(OmekaService::class);
        $item = $omekaService->item($this->data->id);
        return $this->renderObject($item);
    }

    public function search() {
        $omekaService =  Manager::getContainer()->get(OmekaService::class);
        $list = $omekaService->search($this->data->search);
        return $this->renderList($list);
    }

}


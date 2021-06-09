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

    public function item()
    {
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $item = $omekaService->item($this->data->id);
        return $this->renderObject($item);
    }

    public function search()
    {
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $list = $omekaService->search($this->data->search);
        return $this->renderList($list);
    }

    public function fullTextSearch()
    {
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $list = $omekaService->fullTextSearch($this->data->search);
        return $this->renderList($list);
    }

    public function formSearch()
    {
        mdump($this->data);
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->colecoes = $omekaService->colecoes();
        $this->data->tags = $omekaService->tags();
        $this->data->anos = $omekaService->anos();
        return $this->render();
    }

    public function browseItems()
    {
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->limit = 30;
        $this->data->items = $omekaService->browseItems();
        return $this->render();
    }

    public function browseImages()
    {
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->limit = 15;
        $this->data->images = $omekaService->browseImages();
        return $this->render();
    }

    public function itemGallery() {
        return $this->render();
    }

    public function showItem() {
        $omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->item = $omekaService->getItem($this->data->id);
        return $this->render();
    }

    public function socialSharing() {
        return $this->render();
    }

    public function timeline() {
        return $this->render();
    }

}


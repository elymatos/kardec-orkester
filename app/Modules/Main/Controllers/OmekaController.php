<?php

namespace App\Modules\Main\Controllers;

use App\Modules\Main\Services\OmekaService;
use Orkester\Manager;
use Orkester\MVC\MController;
use Orkester\MVC\MView;

class OmekaController extends MController
{
    private OmekaService $omekaService;

    public function __construct(OmekaService $service)
    {
        parent::__construct();
        $this->omekaService = $service;
    }

    public function main()
    {
        $result = (object)[
            'result' => 'Omeka!'
        ];
        return $this->renderObject($result);
    }

    public function item()
    {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $item = $this->omekaService->item($this->data->id);
        return $this->renderObject($item);
    }

    public function search()
    {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $list = $this->omekaService->search($this->data->search);
        return $this->renderList($list);
    }

    public function fullTextSearch()
    {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $list = $this->omekaService->fullTextSearch($this->data->search);
        return $this->renderList($list);
    }

    public function formSearch()
    {
        mdump($this->data);
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->colecoes = $this->omekaService->colecoes();
        $this->data->tags = $this->omekaService->tags();
        $this->data->anos = $this->omekaService->anos();
        return $this->render();
    }

    public function browseItems()
    {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->limit = 30;
        $this->data->items = $this->omekaService->browseItems();
        return $this->render();
    }

    public function browseImages()
    {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->limit = 15;
        $this->data->images = $this->omekaService->browseImages();
        return $this->render();
    }

    public function itemGallery() {
        return $this->render();
    }

    public function showItem() {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->item = $this->omekaService->getItem($this->data->id);
        return $this->render('showItem');
    }

    public function socialSharing() {
        return $this->render();
    }

    public function timeline() {
        return $this->render();
    }

    public function formListBy()
    {
        mdump($this->data);
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $lists = $this->omekaService->listItemsBy();
        $this->data->items = $lists[0];
        $this->data->detail = $lists[1];
        mdump($this->data->items);
        mdump($this->data->detail);
        return $this->render();
    }

    public function listItemsBy()    {
        //$omekaService = Manager::getContainer()->get(OmekaService::class);
        $this->data->items = $this->omekaService->listItemsByValue();
        $viewFile = str_replace("\\", "/", Manager::getAppPath() . "/Modules/Main/Views/Omeka/listItemsBy.blade.php");
        $view = new MView($viewFile);
        $result = $view->process();
        return $this->renderObject((object)[
            'success' => true,
            'data' => $result
        ]);
    }

    public function formListByVariable()
    {
        mdump($this->data);
        $lists = $this->omekaService->listItemsByVariable();
        $this->data->items = $lists;
        return $this->render('formListByVariable');
    }

}


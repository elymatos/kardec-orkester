<?php

namespace App\Modules\Main\Services;

use App\Repositories\ORM\OmekaRepository;
use Orkester\MVC\MService;

class OmekaService extends MService
{

    public function __construct(OmekaRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function item(int $idItem)
    {
        $client = new ClientService();
        $result = $client->test($idItem);
        return $result;
    }

    public function search(string $search)
    {
        $client = new ClientService();
        $result = $client->search($search);
        $list = [];
        foreach ($result as $item) {
            $elements = [];
            foreach ($item->element_texts as $element) {
                $name = $element->element->name;
                if (($name == 'Title') || ($name == 'Subject') || ($name == 'Description') || ($name == 'Date')) {
                    $elements[$name] = $element->text;
                }
            }
            $list[] = (object)[
                'id' => $item->id,
                'elements' => $elements
            ];
        }
        return $list;
    }

    public function tags()
    {
        $tags = $this->repository->listTags($this->data->lang);
        $list = [];
        foreach ($tags as $tag) {
            $list[] = (object)[
                'id' => $tag['id'],
                'name' => $tag['name']
            ];
        }
        return $list;
    }

    public function colecoes()
    {
        $colecoes = $this->repository->listColecoes($this->data->lang);
        $list = [];
        foreach ($colecoes as $colecao) {
            $list[] = (object)[
                'id' => $colecao['id'],
                'name' => $colecao['name']
            ];
        }
        return $list;
    }

    public function anos()
    {
        $anos = $this->repository->listAnos();
        $list = [];
        foreach ($anos as $ano) {
            $list[] = (object)[
                'ano' => $ano['ano'],
            ];
        }
        return $list;
    }

    public function browseItems()
    {
        $items = $this->repository->listItems($this->data);
        $list = [];
        foreach ($items as $item) {
            $list[] = (object)[
                'id' => $item['id'],
                'title' => $item['title'],
                'date' => $item['date'],
            ];
        }
        return $list;
    }

    public function browseImages()
    {
        $items = $this->repository->listImages($this->data);
        $list = [];
        foreach ($items as $item) {
            $list[] = (object)[
                'id' => $item['id'],
                'title' => $item['title'],
                'filename' => $item['filename'],
            ];
        }
        return $list;
    }

    public function getItem(int $idItem)
    {
        $client = new ClientService();
        $item = $client->getItem($idItem);
        $item->id = $idItem;
        $item->files = $this->repository->listFiles($idItem);
        $item->tags = $this->repository->listItemTags($idItem);
        return $item;
    }


}
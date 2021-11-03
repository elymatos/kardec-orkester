<?php

namespace App\Modules\Main\Services;

use App\Repositories\ORM\OmekaRepository;

class OmekaService extends MService
{

    public function __construct()
    {
        $this->repository = new OmekaRepository();
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

    public function fullTextSearch(string $search)
    {
        $result = $this->repository->fullTextSearch($this->data->lang);
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
        mdump($this->data);
        //$client = new ClientService();
        //$itemsSearch = $client->search($this->data->q ?? '');
        //mdump('===' . count($itemsSearch));
        //$itemSearchId = [];
        //foreach ($itemsSearch as $itemSearch) {
        //    $itemSearchId[$itemSearch->id] = $itemSearch->id;
        //}
        $itemsSearch = $this->repository->fullTextSearchLike($this->data->q ?? '');
        foreach ($itemsSearch as $itemSearch) {
            $itemSearchId[$itemSearch['id']] = $itemSearch['id'];
        }
        $items = $this->repository->listItems($this->data);
        $list = [];
        foreach ($items as $item) {
            if ($this->data->q == '') {
                $list[] = (object)[
                    'id' => $item['id'],
                    'title' => $item['title'],
                    'date' => $item['date'],
                    'idCollection' => $item['idCollection'],
                ];
            } else {
                if (isset($itemSearchId[$item['id']])) {
                    $list[] = (object)[
                        'id' => $item['id'],
                        'title' => $item['title'],
                        'date' => $item['date'],
                        'idCollection' => $item['idCollection'],
                    ];
                }
            }
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
        $item = $client->getItem($idItem, $this->data->lang);
        $item->id = $idItem;
        $item->idCollection = $item->collection;
        $item->collection = $this->repository->getColecao($item->collection, $this->data->lang);
        $item->files = $this->repository->listFiles($idItem);
        $item->tags = $this->repository->listItemTags($idItem, $this->data->lang);
        mdump($item);
        return $item;
    }

    public function listItemsBy()
    {
        mdump($this->data);
        $items = $this->repository->listItemsBy($this->data);
        $list = [
            'pubDateInv' => [],
            'collection' => [],
            'year' => [],
            'tag' => []
        ];
        $listDetail = [];
        foreach ($items as $item) {
            $isDetail = (($this->data->q == 'pubDateInv') && ($this->data->value == $item['pubDateInv']))
                || (($this->data->q == 'collection') && ($this->data->value == $item['collection']))
                || (($this->data->q == 'tag') && ($this->data->value == $item['tag']))
                || (($this->data->q == 'year') && ($this->data->value == $item['year']));
            if ($isDetail) {
                $listDetail[] = [
                    $item['id'],
                    $item['title'],
                    $item['date'],
                ];
            }
            $list['pubDateInv'][$item['pubDateInv']] = ($list['pubDateInv'][$item['pubDateInv']] ?? 0) + 1;
            $list['collection'][$item['collection']] = ($list['collection'][$item['collection']] ?? 0) + 1;
            if ($item['tag'] != '') {
                $list['tag'][$item['tag']] = ($list['tag'][$item['tag']] ?? 0) + 1;
            }
            $list['year'][$item['year']] = ($list['year'][$item['year']] ?? 0) + 1;
        }
        krsort($list['pubDateInv']);
        ksort($list['collection']);
        ksort($list['tag']);
        krsort($list['year']);
        return [$list, $listDetail];
    }

    public function listItemsByValue()
    {
        mdump($this->data);
        $items = $this->repository->listItemsByValue($this->data);
        $list = [];
        foreach ($items as $item) {
            $list[] = (object)[
                'id' => $item['id'],
                'title' => $item['title'],
                'date' => $item['date'],
                'idCollection' => $item['idCollection'],
            ];
        }
        return $list;
    }

    public function listItemsByVariable()
    {
        mdump($this->data);
        $items = $this->repository->listItemsByVariable($this->data);
        $list = [];
        foreach ($items as $item) {
            $line = (object)[
                'id' => $item['id'],
                'title' => $item['title'],
                'date' => $item['date'],
                'idCollection' => $item['idCollection'],
                'header' => ''
            ];
            if ($this->data->q == 'pubDate') {
                $line->header = $item['pubDate'];
            }
            if ($this->data->q == 'year') {
                $line->header = $item['year'];
            }
            if ($this->data->q == 'tag') {
                $line->header = $item['tag'];
            }
            if ($this->data->q == 'collection') {
                $line->header = $item['collection'];
            }
            $list[] = $line;
        }
        return $list;
    }

}
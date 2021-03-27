<?php

namespace App\Modules\Main\Services;

use Orkester\MVC\MService;

class OmekaService extends MService
{

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
        foreach($result as $item) {
            $elements = [];
            foreach($item->element_texts as $element) {
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

}
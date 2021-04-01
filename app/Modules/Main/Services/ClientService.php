<?php
namespace App\Modules\Main\Services;

use GuzzleHttp\Client;

class ClientService
{

    public function test($id)
    {

        $client = new Client([
            'base_uri' => 'https://omeka.projetokardec.ufjf.br',
            'timeout' => 300.0,
        ]);

        try {
            $response = $client->request('get', "/api/items/{$id}", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'text/html; charset=UTF-8'
                ],
                //'query' => [
                //]
            ]);
            $body = json_decode($response->getBody());
            return $body;
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return '';
        }
    }

    public function search(string $text = '', int $itemType = 20)
    {

        $client = new Client([
            'base_uri' => 'https://omeka.projetokardec.ufjf.br',
            'timeout' => 300.0,
        ]);

        try {
            $query = [];
            if ($text != '') {
                $query['search'] = $text;
            }
            if ($itemType != '') {
                $query['item_type'] = $itemType;
            }
            $response = $client->request('get', "/api/items", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'text/html; charset=UTF-8'
                ],
                'query' => $query
            ]);
            mdump($response->getHeaderLine('Link'));
            $body = json_decode($response->getBody());
            return $body;
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return '';
        }
    }

    public function tags()
    {
        $client = new Client([
            'base_uri' => 'https://omeka.projetokardec.ufjf.br',
            'timeout' => 300.0,
        ]);

        try {
            $response = $client->request('get', "/api/tags", [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'text/html; charset=UTF-8'
                ],
            ]);
            $body = json_decode($response->getBody());
            return $body;
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
            return '';
        }
    }
}
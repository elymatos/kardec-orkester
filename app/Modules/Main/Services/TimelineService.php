<?php

namespace App\Modules\Main\Services;

use App\Repositories\ORM\OmekaRepository;
use Orkester\MVC\MService;

class TimelineService extends MService
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

}
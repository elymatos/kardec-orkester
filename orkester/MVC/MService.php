<?php

namespace Orkester\MVC;

use Orkester\Manager;

class MService
{
    protected MRepositoryORM $repository;
    protected object $data;

    public function __construct()
    {
        mtrace('MService::construct');
        $this->data = Manager::getData();
    }

    public function __invoke() {
        return null;
    }
}
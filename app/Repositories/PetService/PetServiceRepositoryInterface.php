<?php

namespace App\Repositories\PetService;

use App\Repositories\RepositoryInterface;

interface PetServiceRepositoryInterface extends RepositoryInterface
{
    public function getServiceList();

    public function storeService($data);

    public function updateService($data, $id);

    public function deleteService($id);

    public function isValid($id);
}

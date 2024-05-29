<?php

namespace App\Repositories\PetServicePrice;

use App\Repositories\RepositoryInterface;

interface PetServicePriceRepositoryInterface extends RepositoryInterface
{
    public function getServicePriceList($serviceID);

    public function storeServicePrice($data, $serviceID);

    public function updateServicePrice($data, $id);

    public function deleteServicePrice($id);

    public function isValid($id);

    public function checkExistWeight($petServiceID, $weight);

    public function getPriceByWeight($petServiceID, $weight);
}

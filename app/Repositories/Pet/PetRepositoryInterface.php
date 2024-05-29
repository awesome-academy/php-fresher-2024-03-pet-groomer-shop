<?php

namespace App\Repositories\Pet;

use App\Repositories\RepositoryInterface;

interface PetRepositoryInterface extends RepositoryInterface
{
    public function getPetList($conditions);

    public function getPetCustomer($conditions);

    public function getPetOptions();

    public function getPetCustomerList($conditions);

    public function getPetOptionsFromDB($isOwner);

    public function storePet($data, $userID, $userIDInput, $isActive);

    public function storeCustomer($data, $userID, $isActive);

    public function updatePet($data, $petID, $isActive);

    public function updatePetCustomer($data, $petID, $isActive);

    public function deletePet($petID);
}

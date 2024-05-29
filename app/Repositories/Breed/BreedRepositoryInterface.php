<?php

namespace App\Repositories\Breed;

use App\Repositories\RepositoryInterface;

interface BreedRepositoryInterface extends RepositoryInterface
{
    public function checkValidName($breedName, $breedType, $breedID = null);

    public function getBreedOption();

    public function getBreedList();

    public function storeBreed($data);

    public function updateBreed($data, $breedID);

    public function deleteBreed($breedID);

    public function checkValidPetType($breedID, $petType);
}

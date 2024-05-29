<?php

namespace App\Repositories\Pet;

use App\Enums\PetTypeEnum;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\User;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Gate;

class PetRepository extends BaseRepository implements PetRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Pet::class;
    }

    public function getPetList($conditions)
    {
        return $this->model
            ->with(['user', 'breed'])
            ->where($conditions)
            ->paginate(config('constant.data_table.item_per_page'));
    }

    public function getPetOptions()
    {
        $petTypes = PetTypeEnum::getTranslated();
        $petTypesSelected = array_flip($petTypes);
        $petTypesSelectedExtra = $petTypesSelected;
        $petTypesSelectedExtra[__('All')] = '';

        return [
            $petTypes,
            $petTypesSelected,
            $petTypesSelectedExtra,
        ];
    }

    public function storePet($data, $userID, $userIDInput, $isActive)
    {
        if (!$this->checkValidPetType($data['breed_id'], $data['pet_type'])) {
            throw new Exception(trans('breed.invalid_type'));
        }

        if (Gate::denies('create', User::class)) {
            throw new Exception(trans('permission.create_fail'));
        }

        $data['user_id'] = $userIDInput ?? $userID;
        $data['is_active'] = $isActive;

        return $this->create($data);
    }

    public function updatePet($data, $petID, $isActive)
    {
        $pet = $this->model->findOrFail($petID);
        if (!$this->checkValidPetType($data['breed_id'], $data['pet_type'])) {
            throw new Exception(trans('breed.invalid_type'));
        }

        if (Gate::denies('update', $pet)) {
            throw new Exception(trans('permission.update_fail'));
        }

        $data['is_active'] = $isActive;
        $pet->update($data);

        return $pet;
    }

    public function deletePet($petID)
    {
        if (Gate::denies('delete', Pet::class)) {
            throw new Exception(trans('permission.delete_fail'));
        }

        $pet = $this->model->find($petID);
        $pet->delete();
    }

    public function checkValidPetType($breedID, $petType)
    {
        $breed = Breed::findOrFail($breedID);

        return (int) $breed->breed_type === (int) $petType;
    }

    public function getPetCustomer($conditions)
    {
        return $this->model->where('user_id', auth()->user()->user_id)
            ->where($conditions)
            ->paginate(config('constant.data_table.item_per_page'));
    }

    public function getPetOptionsFromDB($isOwner)
    {
        $petOptions = $this->model->pluck('pet_id', 'pet_name');
        if ($isOwner) {
            $petOptions = $this->model->where('user_id', getUser()->user_id)->pluck('pet_id', 'pet_name');
        }

        $petOptions[__('All')] = '';

        return $petOptions;
    }

    public function getPetCustomerList($conditions)
    {
        return $this->model->with(['user', 'breed'])
            ->where($conditions)
            ->where('user_id', auth()->user()->user_id)
            ->paginate(config('constant.data_table.item_per_page'));
    }

    public function storeCustomer($data, $userID, $isActive)
    {
        $this->model->fill($data);
        $this->model->user_id = $userID;
        $this->model->is_active = $isActive;

        return $this->model->save();
    }

    public function updatePetCustomer($data, $petID, $isActive)
    {
        $pet = $this->findOrFail($petID);
        $pet->fill($data);
        $pet->is_active = $isActive;
        $pet->update();

        return $pet;
    }
}

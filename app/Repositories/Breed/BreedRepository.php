<?php

namespace App\Repositories\Breed;

use App\Models\Breed;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Gate;

class BreedRepository extends BaseRepository implements BreedRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Breed::class;
    }

    public function checkValidName($breedName, $breedType, $breedID = null)
    {
        if ($breedID) {
            $breed = $this->model->findOrFail($breedID);
            if ($breed->breed_name === $breedName && $breed->breed_type === $breedType) {
                return false;
            }
        }

        return $this->model->where('breed_name', $breedName)
            ->where('breed_type', $breedType)->exists();
    }

    public function getBreedOption()
    {
        return $this->model->pluck('breed_id', 'breed_name');
    }

    public function getBreedList()
    {
        return $this->model->orderBy('breed_type')
            ->paginate(config('constant.data_table.item_per_page'));
    }

    public function storeBreed($data)
    {
        if (Gate::denies('create', User::class)) {
            throw new \Exception(trans('permission.create_fail'));
        }

        $this->model->fill($data);

        if ($this->checkValidName($this->model->breed_name, $this->model->breed_type)) {
            throw new \Exception(trans('breed.name_duplicate'));
        }

        $this->model->save();
    }

    public function updateBreed($data, $breedID)
    {
        $breed = $this->findOrFail($breedID);
        if (Gate::denies('update', $breed)) {
            throw new \Exception(trans('permission.update_fail'));
        }

        $breed->fill($data);
        if (
            $this->checkValidName(
                $breed->breed_name,
                $breed->breed_type,
                $breedID
            )
        ) {
            throw new \Exception(trans('breed.name_duplicate'));
        }

        $breed->update();
    }

    public function deleteBreed($breedID)
    {
        $breed = $this->findOrFail($breedID);
        if (Gate::denies('delete', $breed)) {
            throw new \Exception(trans('permission.delete_fail'));
        }

        $breed->delete();
    }

    public function checkValidPetType($breedID, $petType)
    {
        $breed = Breed::findOrFail($breedID);

        return (int) $breed->breed_type === (int) $petType;
    }
}

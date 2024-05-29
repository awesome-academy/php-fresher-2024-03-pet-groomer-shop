<?php

namespace App\Repositories\PetService;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Gate;

class PetServiceRepository extends BaseRepository implements PetServiceRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\PetService::class;
    }

    public function getServiceList()
    {
        return $this->model->paginate(config('constant.data_table.item_per_page'));
    }

    public function storeService($data)
    {
        if (Gate::denies('create', User::class)) {
            throw new \Exception(trans('permission.create_fail'));
        }

        $this->model->fill($data);

        return $this->model->save();
    }

    public function updateService($data, $id)
    {
        $petService = $this->findOrFail($id);

        if (Gate::denies('update', $petService)) {
            throw new \Exception(trans('permission.update_fail'));
        }

        $petService->update($data);
    }

    public function deleteService($id)
    {
        $petService = $this->findOrFail($id);
        if (Gate::denies('delete', $petService)) {
            flashMessage('error', trans('permission.delete_fail'));

            throw new \Exception(trans('permission.delete_fail'));
        }

        $petService->delete();
    }

    public function isValid($id)
    {
        return $this->model->where('pet_service_id', $id)->exists();
    }
}

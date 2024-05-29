<?php

namespace App\Repositories\PetServicePrice;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Gate;

class PetServicePriceRepository extends BaseRepository implements PetServicePriceRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\PetServicePrice::class;
    }

    public function getServicePriceList($serviceID)
    {
        return $this->model->where(
            'pet_service_id',
            $serviceID
        )->orderBy('pet_service_weight', 'asc')
            ->paginate(config('constant.data_table.item_per_page'));
    }

    public function storeServicePrice($data, $serviceID)
    {
        if (Gate::denies('create', User::class)) {
            throw new \Exception(trans('permission.create_fail'));
        }

        if (
            $this->checkExistWeight(
                $serviceID,
                $data['pet_service_weight']
            )
        ) {
            throw new \Exception(trans('pet-service-price.weight_exists'));
        }

        $this->model->fill($data);
        $this->model->pet_service_id = $serviceID;

        return $this->model->save();
    }

    public function updateServicePrice($data, $id)
    {
        $petServicePrice = $this->findOrFail($id);
        if (Gate::denies('update', $petServicePrice)) {
            throw new \Exception(trans('permission.update_fail'));
        }

        $petServicePrice->fill($data);
        $petServicePrice->update();

        return $petServicePrice;
    }

    public function deleteServicePrice($id)
    {
        $petServicePrice = $this->findOrFail($id);
        if (Gate::denies('delete', $petServicePrice)) {
            throw new \Exception(trans('permission.delete_fail'));
        }

        $petServicePrice->delete();
    }

    public function isValid($id)
    {
        return $this->model->where('pet_service_id', $id)->exists();
    }

    public function checkExistWeight($petServiceID, $weight): bool
    {
        return $this->model->where('pet_service_id', $petServiceID)->where('pet_service_weight', $weight)->exists();
    }

    public function getPriceByWeight($petServiceID, $weight)
    {
        $prices = $this->model->where('pet_service_id', $petServiceID)->orderBy('pet_service_weight', 'asc')->get();
        if ($prices->isEmpty()) {
            return 0;
        }

        if ($prices->count() === 1) {
            return (float) $prices->first()->pet_service_price;
        }

        foreach ($prices as $price) {
            if (ceil($weight) <= (int) $price->pet_service_weight) {
                return (float) $price->pet_service_price;
            }
        }

        return (float) $prices->last()->pet_service_price;
    }
}

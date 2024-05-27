<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PetTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Http\Requests\Search\PetSearchRequest;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Role;

class CustomerPetController extends Controller
{
    public function index(PetSearchRequest $request)
    {
        $conditions = formatQuery($request->query());
        $pets = Pet::with(['user', 'breed'])
            ->where($conditions)
            ->where('user_id', auth()->user()->user_id)
            ->paginate(config('constant.data_table.item_per_page'));
        $oldInput = $request->all();
        $breeds = Breed::pluck('breed_id', 'breed_name');
        [$petTypesSelected, $petTypesSelectedExtra] = $this->getPetTypeOptions();

        return view('customer.pet.index', [
            'pets' => $pets,
            'breeds' => $breeds,
            'petTypesSelected' => $petTypesSelected,
            'oldInput' => $oldInput,
            'petTypesSelectedExtra' => $petTypesSelectedExtra,
        ]);
    }

    public function create()
    {
        $breadcrumbItems = [
            [
                'text' => trans('Pet'),
                'url' => route(
                    'customer-pet.index',
                    ['customer' => auth()->user()->user_id]
                ),
            ],
            [
                'text' => trans('Create Pet'),
                'url' => route(
                    'customer-pet.create',
                    ['customer' => auth()->user()->user_id]
                ),
            ],
        ];

        $petTypes = PetTypeEnum::getTranslated();
        $petTypesSelected = array_flip($petTypes);
        $breeds = Breed::pluck('breed_id', 'breed_name');
        $roles = Role::pluck('role_id', 'role_name');

        return view('customer.pet.create', [
            'breeds' => $breeds,
            'roles' => $roles,
            'petTypes' => $petTypes,
            'petTypesSelected' => $petTypesSelected,
            'breadcrumbItems' => $breadcrumbItems,
        ]);
    }

    public function store(PetRequest $request, $customerID)
    {
        try {
            if (Breed::checkValidPetType($request->breed_id, $request->pet_type)) {
                throw new \Exception(__('breed.invalid_type'));
            }

            $pet = new Pet();
            $pet->fill($request->all());
            $pet->user_id = $customerID;
            $pet->is_active = $request->has('is_active') ? 1 : 0;

            $pet->save();
            uploadImg($request, 'pet_avatar', $pet);

            return redirect()
                ->route(
                    'customer-pet.index',
                    ['customer' => $customerID]
                )
                ->with('success', __('Pet created successfully'));
        } catch (\Exception $e) {
            return redirect()
                ->route(
                    'customer-pet.create',
                    ['customer' => $customerID]
                )
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(PetRequest $request, $customerID, $petID)
    {
        try {
            if (!Breed::checkValidPetType($request->breed_id, $request->pet_type)) {
                throw new \Exception(__('breed.invalid_type'));
            }

            $pet = Pet::findOrFail($petID);
            $pet->fill($request->all());
            $pet->is_active = $request->has('is_active') ? 1 : 0;
            $pet->update();
            uploadImg($request, 'pet_avatar', $pet);

            return redirect()
                ->route(
                    'customer-pet.index',
                    ['customer' => $customerID]
                )
                ->with('success', __('Pet updated successfully'));
        } catch (\Exception $e) {
            return redirect()
                ->route(
                    'customer-pet.index',
                    ['customer' => $customerID]
                )
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($customerID, $petID)
    {
        try {
            $pet = Pet::findOrFail($petID);
            $pet->delete();
            flashMessage('success', __('Pet deleted successfully'));
        } catch (\Exception $e) {
            flashMessage('error', $e->getMessage());
        }
    }

    private function getPetTypeOptions()
    {
        $petTypes = PetTypeEnum::getTranslated();
        $petTypesSelected = array_flip($petTypes);
        $petTypesSelectedExtra = $petTypesSelected;
        $petTypesSelectedExtra[__('All')] = '';

        return [$petTypesSelected, $petTypesSelectedExtra];
    }
}

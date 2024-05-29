<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PetTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PetRequest;
use App\Http\Requests\Search\PetSearchRequest;
use App\Repositories\Breed\BreedRepositoryInterface;
use App\Repositories\Pet\PetRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;

class CustomerPetController extends Controller
{
    protected $petRepo;
    protected $breedRepo;
    protected $roleRepo;

    public function __construct(
        PetRepositoryInterface $petRepo,
        BreedRepositoryInterface $breedRepo,
        RoleRepositoryInterface $roleRepo
    ) {
        $this->breedRepo = $breedRepo;
        $this->$petRepo = $petRepo;
        $this->$roleRepo = $roleRepo;
    }

    public function index(PetSearchRequest $request)
    {
        $conditions = formatQuery($request->query());
        $pets = $this->petRepo->getPetCustomerList($conditions);
        $breeds = $this->breedRepo->getBreedOption();
        [$petTypesSelected, $petTypesSelectedExtra] = $this->getPetTypeOptions();

        return view('customer.pet.index', [
            'pets' => $pets,
            'breeds' => $breeds,
            'petTypesSelected' => $petTypesSelected,
            'oldInput' => $request->all(),
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
        $breeds = $this->breedRepo->getBreedOption();
        $roles = $this->roleRepo->getRoleOption();

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
            if (!$this->breedRepo->checkValidPetType($request->breed_id, $request->pet_type)) {
                throw new \Exception(__('breed.invalid_type'));
            }

            $isActive = $request->has('is_active') ? 1 : 0;
            $pet = $this->petRepo->storeCustomer($request->all(), $customerID, $isActive);

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
            if (!$this->breedRepo->checkValidPetType($request->breed_id, $request->pet_type)) {
                throw new \Exception(__('breed.invalid_type'));
            }

            $isActive = $request->has('is_active') ? 1 : 0;
            $pet = $this->petRepo->updatePetCustomer($request->all(), $petID, $isActive);
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
            $this->petRepo->delete($petID);
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

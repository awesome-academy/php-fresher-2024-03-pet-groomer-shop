<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Http\Requests\Search\PetSearchRequest;
use App\Repositories\Breed\BreedRepositoryInterface;
use App\Repositories\Pet\PetRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;

class PetController extends Controller
{
    protected $petRepo;
    protected $breedRepo;
    protected $roleRepo;
    protected $userRepo;

    public function __construct(
        PetRepositoryInterface $petRepo,
        BreedRepositoryInterface $breedRepo,
        RoleRepositoryInterface $roleRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->petRepo = $petRepo;
        $this->breedRepo = $breedRepo;
        $this->roleRepo = $roleRepo;
        $this->userRepo = $userRepo;
    }

    public function index(PetSearchRequest $request)
    {
        $conditions = formatQuery($request->query());
        $pets = $this->petRepo->getPetList($conditions);
        $breeds = $this->breedRepo->getBreedOption();
        [
            $petTypes,
            $petTypesSelected,
            $petTypesSelectedExtra,
        ] = $this->petRepo->getPetOptions();

        return view('pet.index', [
            'pets' => $pets,
            'breeds' => $breeds,
            'petTypes' => $petTypes,
            'petTypesSelected' => $petTypesSelected,
            'oldInput' => $request->all(),
            'petTypesSelectedExtra' => $petTypesSelectedExtra,
            'oldInput' => $request->all(),
        ]);
    }

    public function create()
    {
        $breadcrumbItems = [
            ['text' => trans('Pet'), 'url' => route('pet.index')],
            ['text' => trans('Create Pet'), 'url' => route('pet.create')],
        ];
        [$petTypes, $petTypesSelected] = $this->petRepo->getPetOptions();
        $breeds = $this->breedRepo->getBreedOption();
        $roles = $this->roleRepo->getRoleOption();
        $userOptions = $this->userRepo->getUserOption();

        return view('pet.create', [
            'breeds' => $breeds,
            'userOptions' => $userOptions,
            'roles' => $roles,
            'petTypes' => $petTypes,
            'petTypesSelected' => $petTypesSelected,
            'breadcrumbItems' => $breadcrumbItems,
        ]);
    }

    public function store(PetRequest $request, int $userID)
    {
        try {
            $data = $request->except('_token');
            $userIDInput = $request->input('user_id');
            $isActive = $request->has('is_active') ? 1 : 0;
            $this->petRepo->storePet($data, $userID, $userIDInput, $isActive);
            uploadImg($request, 'pet_avatar', 'pet_avatar');
            if ($userIDInput) {
                return redirect()
                    ->route('pet.index')
                    ->with('success', __('Pet created successfully'));
            }

            return redirect()
                ->route('user.show', $userID)
                ->with('success', __('Pet created successfully'));
        } catch (Exception $exception) {
            return redirect()
                ->route('user.show', $userID)
                ->with('error', $exception->getMessage());
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

    public function update(PetRequest $request, $id, $userID)
    {
        try {
            $isActive = $request->has('is_active') ? 1 : 0;
            $pet = $this->petRepo->updatePet(
                $request->except(['_token', '_method', 'redirect_pet_index']),
                $id,
                $isActive
            );
            $redirectValue = $request->input('redirect_pet_index');
            uploadImg($request, 'pet_avatar', $pet);
            if ($redirectValue === 1) {
                return redirect()->route('pet.index')->with(
                    'success',
                    __('Pet updated successfully')
                );
            }

            return redirect()->route('user.show', $userID)->with(
                'success',
                __('Pet updated successfully')
            );
        } catch (Exception $exception) {
            if ($redirectValue === 1) {
                return redirect()->route('pet.index')->with(
                    'success',
                    __('Pet updated successfully')
                );
            }

            return redirect()
                ->route('user.show', $userID)
                ->with(
                    'success',
                    __('Pet updated successfully')
                );
        } catch (Exception $exception) {
            return redirect()
                ->route('user.show', $userID)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->petRepo->deletePet($id);
            flashMessage('success', __('Pet deleted successfully'));
        } catch (Exception $exception) {
            flashMessage('error', $exception->getMessage());
        }
    }
}

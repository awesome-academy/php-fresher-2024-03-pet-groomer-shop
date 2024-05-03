<?php

namespace App\Http\Controllers;

use App\Enums\PetTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\PetRequest;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('user')->paginate(config('constant.data_table.item_per_page'));

        $breeds = Breed::pluck('breed_id', 'breed_name');

        $activeMenu = StatusEnum::getTranslated();
        $petTypes = PetTypeEnum::getTranslated();
        $petTypesSelected = array_flip($petTypes);

        return view('pet.index', [
            'pets' => $pets,
            'breeds' => $breeds,
            'activeMenu' => $activeMenu,
            'petTypes' => $petTypes,
            'petTypesSelected' => $petTypesSelected,
        ]);
    }

    public function create()
    {
        $breadcrumbItems = [
            ['text' => trans('Pet'), 'url' => route('pet.index')],
            ['text' => trans('Create Pet'), 'url' => route('pet.create')],
        ];

        $petTypes = PetTypeEnum::getTranslated();
        $petTypesSelected = array_flip($petTypes);
        $breeds = Breed::pluck('breed_id', 'breed_name');
        $roles = Role::pluck('role_id', 'role_name');
        $userOptions = User::pluck('user_id', 'user_email');

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

            if (Gate::denies('create', User::class)) {
                throw new Exception(trans('permission.create_fail'));
            }

            $userIDInput = $request->input('user_id');
            $data['user_id'] = $userIDInput ?? $userID;
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            DB::table('pets')->insert($data);
            if ($userIDInput) {
                return redirect()->route('pet.index')->with('success', __('Pet created successfully'));
            }

            return redirect()->route('user.show', $userID)->with('success', __('Pet created successfully'));
        } catch (Exception $exception) {
            if ($userIDInput) {
                return redirect()->route('pet.index')->with('error', $exception->getMessage());
            }

            return redirect()->route('user.show', $userID)->with('error', $exception->getMessage());
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
        return view('pet.show');
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
            $pet = Pet::findOrFail($id);
            if (Gate::denies('update', $pet)) {
                throw new Exception(trans('permission.update_fail'));
            }

            $data = $request->except(['_token', '_method', 'redirect_pet_index']);
            $redirectValue = $request->input(
                'redirect_pet_index'
            );
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $pet->update($data);

            if ((int) $redirectValue === 1) {
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
            if ((int) $redirectValue === 1) {
                return redirect()->route('pet.index')->with(
                    'error',
                    $exception->getMessage()
                );
            }

            return redirect()->route(
                'user.show',
                $userID
            )->with(
                'error',
                $exception->getMessage()
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $userID)
    {
        try {
            if (Gate::denies('delete', Pet::class)) {
                throw new Exception(trans('permission.delete_fail'));
            }

            $pet = Pet::find($id);
            // Check if the current user is authorized to delete the pet
            if (Gate::allows('delete', $pet)) {
                // Authorized to delete the pet
                DB::table('pets')->where('pet_id', $id)->delete();
                flashMessage('success', __('Pet deleted successfully'));
            }
        } catch (Exception $exception) {
            flashMessage('error', $exception->getMessage());
        }
    }
}

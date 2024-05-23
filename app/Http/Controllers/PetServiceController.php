<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetServiceRequest;
use App\Models\PetService;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class PetServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petServices = PetService::paginate(config('constant.data_table.item_per_page'));

        return view('pet-service.index', ['petServices' => $petServices]);
    }

    public function create()
    {
        $breadcrumbItems = [
            ['text' => trans('pet-service.pet_service'), 'url' => route('pet-service.index')],
            ['text' => trans('pet-service.create'), 'url' => route('pet-service.create')],
        ];

        return view('pet-service.create', [
            'breadcrumbItems' => $breadcrumbItems,
        ]);
    }

    public function store(PetServiceRequest $request)
    {
        try {
            if (Gate::denies('create', User::class)) {
                throw new Exception(trans('permission.create_fail'));
            }

            $petService = new PetService();
            $petService->fill($request->all());
            $petService->save();

            return redirect()
                ->route('pet-service.index')
                ->with('success', trans('pet-service.create_success'));
        } catch (Exception $e) {
            return redirect()
                ->route('pet-service.create')
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

    public function edit($id)
    {
        try {
            $petService = PetService::findOrFail($id);
            $breadcrumbItems = [
                ['text' => trans('pet-service.pet_service'), 'url' => route('pet-service.index')],
                ['text' => trans('pet-service.update'), 'url' => route('pet-service.edit', $id)],
            ];

            return view('pet-service.edit', [
                'petService' => $petService,
                'breadcrumbItems' => $breadcrumbItems,
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(PetServiceRequest $request, $id)
    {
        try {
            $petService = PetService::findOrFail($id);

            if (Gate::denies('update', $petService)) {
                throw new Exception(trans('permission.update_fail'));
            }

            $petService->update($request->all());

            return redirect()
                ->route('pet-service.index')
                ->with('success', trans('pet-service.update_success'));
        } catch (Exception $e) {
            return redirect()
                ->route('pet-service.edit')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $petService = PetService::findOrFail($id);
            if (Gate::denies('delete', $petService)) {
                flashMessage('error', trans('permission.delete_fail'));

                throw new Exception(trans('permission.delete_fail'));
            }

            $petService->delete();
            flashMessage('success', trans('pet-service.delete_success'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}

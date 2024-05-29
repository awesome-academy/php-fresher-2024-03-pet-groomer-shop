<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetServiceRequest;
use App\Repositories\PetService\PetServiceRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetServiceController extends Controller
{
    protected $petServiceRepo;

    public function __construct(PetServiceRepositoryInterface $petServiceRepo)
    {
        $this->petServiceRepo = $petServiceRepo;
    }

    public function index()
    {
        $petServices = $this->petServiceRepo->getServiceList();

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
            $this->petServiceRepo->storeService($request->all());

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
            $petService = $this->petServiceRepo->findOrFail($id);
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
            $this->petServiceRepo->updateService($request->all(), $id);

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
            $this->petServiceRepo->deleteService($id);
            flashMessage('success', trans('pet-service.delete_success'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
}

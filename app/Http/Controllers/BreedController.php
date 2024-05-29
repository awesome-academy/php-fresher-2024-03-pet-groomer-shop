<?php

namespace App\Http\Controllers;

use App\Enums\PetTypeEnum;
use App\Http\Requests\BreedRequest;
use App\Repositories\Breed\BreedRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BreedController extends Controller
{
    protected $breedRepo;

    public function __construct(BreedRepositoryInterface $breedRepo)
    {
        $this->breedRepo = $breedRepo;
    }

    public function index()
    {
        $breeds = $this->breedRepo->getBreedList();

        return view('breed.index', ['breeds' => $breeds]);
    }

    public function create()
    {
        $breadcrumbItems = [
            [
                'text' => trans('breed.breed'),
                'url' => route('breed.index'),
            ],
            [
                'text' => trans('breed.update'),
                'url' => route('breed.create'),
            ],
        ];
        $petTypeOptions = $this->getPetTypeOptions();

        return view('breed.create', ['breadcrumbItems' => $breadcrumbItems, 'petTypeOptions' => $petTypeOptions]);
    }

    public function store(BreedRequest $request)
    {
        try {
            $this->breedRepo->storeBreed($request->all());

            return redirect()->route('breed.index')->with('success', trans('breed.create_success'));
        } catch (\Exception $e) {
            return redirect()->route('breed.create')->with('error', $e->getMessage());
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
            $breadcrumbItems = [
                ['text' => trans('breed.breed'), 'url' => route('breed.index')],
                ['text' => trans('breed.update'), 'url' => ''],
            ];
            $breed = $this->breedRepo->findOrFail($id);
            $petTypeOptions = $this->getPetTypeOptions();

            return view(
                'breed.edit',
                [
                    'breed' => $breed,
                    'breadcrumbItems' => $breadcrumbItems,
                    'petTypeOptions' => $petTypeOptions,
                ]
            );
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(BreedRequest $request, $id)
    {
        try {
            $this->breedRepo->updateBreed($request->all(), $id);

            return redirect()->route('breed.index')->with('success', trans('breed.update_success'));
        } catch (Exception $e) {
            return redirect()->route('breed.edit', ['breed' => $id])->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->breedRepo->deleteBreed($id);
            flashMessage('success', trans('breed.delete_success'));
        } catch (Exception $e) {
            flashMessage('error', $e->getMessage());
        }
    }

    private function getPetTypeOptions()
    {
        return array_flip(PetTypeEnum::getTranslated());
    }
}

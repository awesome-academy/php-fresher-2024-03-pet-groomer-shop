<?php

namespace App\Http\Controllers;

use App\Enums\PetTypeEnum;
use App\Http\Requests\BreedRequest;
use App\Models\Breed;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BreedController extends Controller
{
    public function index(Request $request)
    {
        $conditions = formatQuery($request->query());
        $breeds = Breed::where($conditions)
            ->orderBy('breed_type')
            ->paginate(config('constant.data_table.item_per_page'));

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
            if (Breed::checkValidName($request)) {
                throw new Exception(trans('breed.name_duplicate'));
            }

            if (Gate::denies('create', User::class)) {
                throw new Exception(trans('permission.create_fail'));
            }

            $breed = new Breed();
            $breed->fill($request->all());
            $breed->save();

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
            $breed = Breed::findOrFail($id);
            $breadcrumbItems = [
                ['text' => trans('breed.breed'), 'url' => route('breed.index')],
                ['text' => trans('breed.update'), 'url' => route('breed.edit', ['breed' => $breed->breed_id])],
            ];

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
            if (Breed::checkValidNameUpdate($request, $id)) {
                throw new Exception(trans('breed.name_duplicate'));
            }

            $breed = Breed::findOrFail($id);
            if (Gate::denies('update', $breed)) {
                throw new Exception(trans('permission.update_fail'));
            }

            $breed->fill($request->all());
            $breed->update();

            return redirect()->route('breed.index')->with('success', trans('breed.update_success'));
        } catch (Exception $e) {
            return redirect()->route('breed.edit', ['breed' => $id])->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $breed = Breed::findOrFail($id);
            if (Gate::denies('delete', $breed)) {
                throw new Exception(trans('permission.delete_fail'));
            }

            $breed->delete();
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

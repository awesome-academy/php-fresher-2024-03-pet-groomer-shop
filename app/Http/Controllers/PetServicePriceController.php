<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetServicePriceRequest;
use App\Models\PetService;
use App\Models\PetServicePrice;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class PetServicePriceController extends Controller
{
    public function index($petServiceID)
    {
        try {
            $this->checkValidPetService($petServiceID);
            $petService = PetService::findOrFail($petServiceID);
            $petServicePrices = PetServicePrice::where(
                'pet_service_id',
                $petServiceID
            )->orderBy('pet_service_weight', 'asc')
                ->paginate(config('constant.data_table.item_per_page'));

            return view(
                'pet-service-price.index',
                [
                    'petServicePrices' => $petServicePrices,
                    'petServiceID' => $petServiceID,
                    'petService' => $petService,
                ]
            );
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function create($petServiceID)
    {
        $breadcrumbItems = [
            [
                'text' => trans('pet-service-price.pet_service_price'),
                'url' => route(
                    'pet-service-price.index',
                    ['pet_service' => $petServiceID]
                ),
            ],
            [
                'text' => trans('pet-service-price.create'),
                'url' => route(
                    'pet-service-price.create',
                    ['pet_service' => $petServiceID]
                ),
            ],
        ];

        return view('pet-service-price.create', [
            'breadcrumbItems' => $breadcrumbItems,
            'petServiceID' => $petServiceID,
        ]);
    }

    public function store(PetServicePriceRequest $request, $petServiceID)
    {
        try {
            if (Gate::denies('create', User::class)) {
                throw new Exception(trans('permission.create_fail'));
            }

            if (
                PetServicePrice::checkExistWeight(
                    $petServiceID,
                    $request->pet_service_weight
                )
            ) {
                throw new Exception(trans('pet-service-price.weight_exists'));
            }

            $petServicePrice = new PetServicePrice();
            $petServicePrice->fill($request->all());
            $petServicePrice->pet_service_id = $petServiceID;
            $petServicePrice->save();

            return redirect()->route(
                'pet-service-price.index',
                ['pet_service' => $petServiceID]
            )->with('success', trans('pet-service-price.create_success'));
        } catch (Exception $e) {
            return redirect()->route(
                'pet-service-price.create',
                ['pet_service' => $petServiceID]
            )->with('error', $e->getMessage());
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
    public function edit($petServiceID, $petServicePriceID)
    {
        try {
            $this->checkValidPetService($petServiceID);
            $petServicePrice = PetServicePrice::findOrFail($petServicePriceID);

            $breadcrumbItems = [
                [
                    'text' => trans('pet-service-price.pet_service_price'),
                    'url' => route(
                        'pet-service-price.index',
                        ['pet_service' => $petServiceID]
                    ),
                ],
                [
                    'text' => trans('pet-service-price.update'),
                    'url' => route(
                        'pet-service-price.edit',
                        ['pet_service' => $petServiceID, 'pet_service_price' => $petServicePriceID]
                    ),
                ],
            ];

            return view(
                'pet-service-price.edit',
                [
                    'petServicePrice' => $petServicePrice,
                    'petServiceID' => $petServiceID,
                    'breadcrumbItems' => $breadcrumbItems,
                ]
            );
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function update(PetServicePriceRequest $request, $petServiceID, $petServicePriceID)
    {
        try {
            $petServicePrice = PetServicePrice::findOrFail($petServicePriceID);
            if (Gate::denies('update', $petServicePrice)) {
                throw new Exception(trans('permission.update_fail'));
            }

            $petServicePrice->fill($request->all());
            $petServicePrice->update();

            return redirect()
                ->route(
                    'pet-service-price.index',
                    ['pet_service' => $petServicePrice->pet_service_id]
                )
                ->with('success', trans('pet-service-price.update_success'));
        } catch (Exception $e) {
            return redirect()
                ->route(
                    'pet-service-price.edit',
                    [
                        'pet_service' => $petServicePrice->pet_service_id,
                        'pet_service_price' => $petServicePriceID,
                    ]
                )
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($petServiceID, $petServicePriceID)
    {
        try {
            PetService::findOrFail($petServiceID);
            $petServicePrice = PetServicePrice::findOrFail($petServicePriceID);
            if (Gate::denies('delete', $petServicePrice)) {
                throw new Exception(trans('permission.delete_fail'));
            }

            $petServicePrice->delete();
            flashMessage('success', trans('pet-service-price.delete_success'));
        } catch (Exception $e) {
            flashMessage('error', trans('pet-service-price.delete_fail'));
        }
    }

    private function checkValidPetService($petServiceID)
    {
        if (!PetService::isValid($petServiceID)) {
            abort(404);
        }
    }
}

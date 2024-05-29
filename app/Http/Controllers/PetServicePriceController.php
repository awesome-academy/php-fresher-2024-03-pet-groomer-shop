<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetServicePriceRequest;
use App\Repositories\PetService\PetServiceRepositoryInterface;
use App\Repositories\PetServicePrice\PetServicePriceRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetServicePriceController extends Controller
{
    protected $petServiceRepo;
    protected $petServicePriceRepo;

    public function __construct(
        PetServiceRepositoryInterface $petServiceRepo,
        PetServicePriceRepositoryInterface $petServicePriceRepo
    ) {
        $this->petServiceRepo = $petServiceRepo;
        $this->petServicePriceRepo = $petServicePriceRepo;
    }

    public function index($petServiceID)
    {
        try {
            $this->checkValidPetService($petServiceID);
            $petService = $this->petServiceRepo->findOrFail($petServiceID);
            $petServicePrices = $this->petServicePriceRepo->getServicePriceList($petServiceID);

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
            $this->petServicePriceRepo->storeServicePrice($request->all(), $petServiceID);

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
            $petServicePrice = $this->petServicePriceRepo->findOrFail($petServicePriceID);

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
            $petServicePrice = $this->petServicePriceRepo->update($request->all(), $petServicePriceID);

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
            $this->petServicePriceRepo->deleteServicePrice($petServicePriceID);
            flashMessage('success', trans('pet-service-price.delete_success'));
        } catch (Exception $e) {
            flashMessage('error', trans('pet-service-price.delete_fail'));
        }
    }

    private function checkValidPetService($petServiceID)
    {
        if (!$this->petServiceRepo->isValid($petServiceID)) {
            abort(404);
        }
    }
}

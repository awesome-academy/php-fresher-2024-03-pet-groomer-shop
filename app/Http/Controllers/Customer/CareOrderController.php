<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PetTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CareOrderRequest;
use App\Models\Branch;
use App\Models\Pet;
use App\Models\PetService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CareOrderController extends Controller
{
    public function index(Request $request)
    {
        $conditions = formatQuery($request->query());
        $pets = Pet::where('user_id', auth()->user()->user_id)
            ->where($conditions)
            ->paginate(config('constant.data_table.item_per_page'));
        [$petTypesSelected, $petTypesSelectedExtra] = $this->getPetTypeOptions();

        return view('customer.care-order.index', [
            'pets' => $pets,
            'petTypesSelected' => $petTypesSelected,
            'petTypesSelectedExtra' => $petTypesSelectedExtra,
        ]);
    }

    public function requestPage($petID)
    {
        try {
            $breadcrumbItems = [
                ['text' => trans('care-order.care-order'), 'url' => route('care-order.index')],
                ['text' => trans('care-order.request'), 'url' => route('care-order.request-page', ['pet' => $petID])],
            ];
            $branches = Branch::pluck('branch_id', 'branch_name');

            $pet = Pet::findOrFail($petID);
            if (!$pet->checkOwner()) {
                throw new \Exception();
            }

            $petServices = PetService::all();

            return view(
                'customer.care-order.request',
                [
                    'pet' => $pet,
                    'breadcrumbItems' => $breadcrumbItems,
                    'petServices' => $petServices,
                    'branches' => $branches,
                ]
            );
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function request(CareOrderRequest $request, $petID)
    {
        try {
            if (!$this->checkValidService($request)) {
                throw new \Exception(trans('Invalid service'));
            }

            session()->put('careOrder', $request->except('_token'));

            return redirect()->route('payment.index', ['pet' => $petID]);
        } catch (\Exception $e) {
            return redirect()->route('care-order.request-page', ['pet' => $petID])->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getPetTypeOptions()
    {
        $petTypes = PetTypeEnum::getTranslated();
        $petTypesSelected = array_flip($petTypes);
        $petTypesSelectedExtra = $petTypesSelected;
        $petTypesSelectedExtra[__('All')] = '';

        return [$petTypesSelected, $petTypesSelectedExtra];
    }

    private function checkDatePair($request)
    {
        $fromDatetime = $request->from_datetime;
        $toDatetime = $request->to_datetime;
        $conditionOne = isset($fromDatetime) && !isset($toDatetime);
        $conditionTwo = !isset($fromDatetime) && isset($toDatetime);

        return $conditionOne || $conditionTwo;
    }

    private function checkValidService($request)
    {
        $emptyPetService = !isset($request->pet_service_id);
        $emptyFromDatetime = !isset($request->from_datetime);
        $emptyToDatetime = !isset($request->to_datetime);

        if ($emptyPetService && $emptyFromDatetime && $emptyToDatetime) {
            return false;
        }

        return !$emptyPetService || !$this->checkDatePair($request);
    }
}

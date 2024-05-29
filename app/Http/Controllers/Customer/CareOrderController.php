<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PetTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CareOrderRequest;
use App\Http\Requests\Search\PetSearchRequest;
use App\Models\Pet;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\Pet\PetRepositoryInterface;
use App\Repositories\PetService\PetServiceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CareOrderController extends Controller
{
    protected $petServiceRepo;
    protected $petRepo;
    protected $branchRepo;

    public function __construct(
        PetServiceRepositoryInterface $petServiceRepo,
        PetRepositoryInterface $petRepo,
        BranchRepositoryInterface $branchRepo
    ) {
        $this->petServiceRepo = $petServiceRepo;
        $this->petRepo = $petRepo;
        $this->branchRepo = $branchRepo;
    }

    public function index(PetSearchRequest $request)
    {
        $conditions = formatQuery($request->query());
        $pets = $this->petRepo->getPetCustomer($conditions);
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
            $branches = $this->branchRepo->getBranchOption();

            $pet = Pet::findOrFail($petID);
            if (!$pet->is_active || !$pet->checkOwner()) {
                throw new \Exception('');
            }

            $petServices = $this->petServiceRepo->getAll();

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
            if (!$this->checkValidService($request, $petID)) {
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

    private function checkDatePair($request, $petID)
    {
        $fromDateTime = $request->from_datetime;
        $toDateTime = $request->to_datetime;
        $conditionOne = isset($fromDateTime) && !isset($toDateTime);
        $conditionTwo = !isset($fromDateTime) && isset($toDateTime);

        return $conditionOne || $conditionTwo;
    }

    private function checkValidService($request, $petID)
    {
        $emptyPetService = !isset($request->pet_service_id);
        if ($emptyPetService && !isset($request->from_datetime) && !isset($request->to_datetime)) {
            return false;
        }

        return !$emptyPetService || !$this->checkDatePair($request, $petID);
    }
}

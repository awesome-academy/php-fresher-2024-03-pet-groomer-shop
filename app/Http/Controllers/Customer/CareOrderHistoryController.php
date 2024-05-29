<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\CareOrderHistorySearchRequest;
use App\Repositories\CareOrder\CareOrderRepositoryInterface;
use App\Repositories\CareOrderDetail\CareOrderDetailRepositoryInterface;
use App\Repositories\Pet\PetRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CareOrderHistoryController extends Controller
{
    protected $careOrderRepo;
    protected $petRepo;
    protected $careOrderDetailRepo;

    public function __construct(
        CareOrderRepositoryInterface $careOrderRepo,
        PetRepositoryInterface $petRepo,
        CareOrderDetailRepositoryInterface $careOrderDetailRepo
    ) {
        $this->careOrderRepo = $careOrderRepo;
        $this->$petRepo = $petRepo;
        $this->$careOrderDetailRepo = $careOrderDetailRepo;
    }

    public function index(CareOrderHistorySearchRequest $request)
    {
        $conditions = formatQuery($request->query());
        $careOrders = $this->careOrderRepo->getCareOrderHistory($conditions);
        $petOptions = $this->petRepo->getPetOptionsFromDB(true);
        $oldInput = $request->all();

        return view(
            'customer.care-order-history.index',
            [
                'careOrders' => $careOrders,
                'petOptions' => $petOptions,
                'oldInput' => $oldInput,
            ]
        );
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

    public function show($id)
    {
        try {
            $breadcrumbItems = [
                [
                    'text' => trans('care-order.history'),
                    'url' => route('care-order-history.index'),
                ],
                [
                    'text' => trans('Detail'),
                    'url' => route('care-order-history.show', ['care_order_history' => $id]),
                ],
            ];

            $careOrder = $this->careOrderRepo->getCareOrder($id);

            $petServicePrice = $this->careOrderDetailRepo->getSumPrice($id);

            return view(
                'customer.care-order-history.show',
                [
                    'breadcrumbItems' => $breadcrumbItems,
                    'careOrder' => $careOrder,
                    'petServicePrice' => $petServicePrice,
                ]
            );
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orderID)
    {
        try {
            $this->careOrderRepo->updateOrderStatusForCustomer($orderID);

            return response()->json(['message' => trans('care-order.update_success')]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
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
        //
    }
}

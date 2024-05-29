<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\AssignTaskRequest;
use App\Http\Requests\Search\EmployeeSearchRequest;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\CareOrder\CareOrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    protected $userRepo;
    protected $branchRepo;
    protected $careOrderRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        BranchRepositoryInterface $branchRepo,
        CareOrderRepositoryInterface $careOrderRepo
    ) {
        $this->userRepo = $userRepo;
        $this->branchRepo = $branchRepo;
        $this->careOrderRepo = $careOrderRepo;
    }

    public function index(EmployeeSearchRequest $request)
    {
        $branches = $this->branchRepo->getBranchOption(true);
        $conditions = formatQuery($request->query());
        $employees = $this->userRepo->getEmployeeList($conditions);

        return view(
            'employee.index',
            [
                'employees' => $employees,
                'branches' => $branches,
                'oldInput' => $request->all(),
            ]
        );
    }

    public function assignTaskPage($userID, $branchID)
    {
        if (!$this->branchRepo->checkValid($branchID) || !$this->userRepo->checkValid($userID)) {
            abort(404);
        }

        $breadcrumbItems = [
            [
                'text' => trans('employee.employee'),
                'url' => route('employee.index'),
            ],
            [
                'text' => trans('employee.assign_task'),
                'url' => route('employee.assign-task-page', ['branch' => $branchID, 'employee' => $userID]),
            ],
        ];
        $orders = $this->careOrderRepo->assignTaskList($branchID);
        $employee = $this->userRepo->findOrFail($userID);

        return view(
            'employee.assign-task',
            [

                'orders' => $orders,
                'userID' => $userID,
                'branchID' => $branchID,
                'breadcrumbItems' => $breadcrumbItems,
                'employee' => $employee,
            ]
        );
    }

    public function assignTask(AssignTaskRequest $request, $userID, $orderID)
    {
        DB::beginTransaction();
        try {
            $fromTime = $request->from_time;
            $toTime = $request->to_time;
            $this->userRepo->assignTask($userID, $orderID, $fromTime, $toTime);
            $this->careOrderRepo->updateCareOrderStatus(OrderStatusEnum::IN_PROGRESS, $orderID);
            DB::commit();

            return redirect()->back()->with('success', trans('employee.success'));
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function unassignTask($userID, $orderID)
    {
        try {
            $this->userRepo->unAssignTask($userID, $orderID);
            $this->careOrderRepo->updateCareOrderStatus(OrderStatusEnum::CONFIRMED, $orderID);

            return redirect()->back()->with('success', trans('employee.unassign_success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateAssignTask(AssignTaskRequest $request, $userID, $orderID)
    {
        try {
            $fromTime = $request->from_time;
            $toTime = $request->to_time;
            $this->userRepo->updateAssignTask($userID, $orderID, $fromTime, $toTime);

            return redirect()->back()->with('success', trans('employee.success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
}

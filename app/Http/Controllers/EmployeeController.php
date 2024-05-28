<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Enums\RoleEnum;
use App\Http\Requests\AssignTaskRequest;
use App\Models\Branch;
use App\Models\CareOrder;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::pluck('branch_id', 'branch_name');
        $conditions = formatQuery($request->query());
        $employees = User::with('branch')
            ->where('role_id', RoleEnum::EMPLOYEE)
            ->where($conditions)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constant.data_table.item_per_page'))
            ->withQueryString();
        $oldInput = $request->all();
        $branches['All'] = '';

        return view(
            'employee.index',
            ['employees' => $employees, 'branches' => $branches, 'oldInput' => $oldInput]
        );
    }

    public function assignTaskPage($userID, $branchID)
    {
        if (!Branch::checkValid($branchID) || !User::checkValid($userID)) {
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
        $orders = CareOrder::where('branch_id', $branchID)
            ->with('assignTask')
            ->orderBy('updated_at', 'desc')
            ->paginate(config('constant.data_table.item_per_page'))->withQueryString();
        $employee = User::findOrFail($userID);

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
            $user = User::findOrFail($userID);

            if (Gate::denies('assignTask', $user)) {
                throw new Exception(trans('permission.update_fail'));
            }

            if ($user->isAssigned($orderID)) {
                throw new Exception(trans('employee.already_assigned'));
            }

            if ($user->isOverlappingTask($fromTime, $toTime)) {
                throw new Exception(trans('employee.overlapping'));
            }

            $user->assignTask()->attach($orderID, ['from_time' => $fromTime, 'to_time' => $toTime]);

            $order = CareOrder::findOrFail($orderID);
            $order->order_status = OrderStatusEnum::IN_PROGRESS;
            $order->save();

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
            $user = User::findOrFail($userID);
            if (Gate::denies('unassignTask', $user)) {
                throw new Exception(trans('permission.delete_fail'));
            }

            $user->assignTask()->detach($orderID);
            $order = CareOrder::findOrFail($orderID);
            $order->order_status = OrderStatusEnum::CONFIRMED;
            $order->update();

            return redirect()->back()->with('success', trans('employee.unassign_success'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateAssignTask(AssignTaskRequest $request, $userID, $orderID)
    {
        try {
            $user = User::findOrFail($userID);
            $user->assignTask()
                ->updateExistingPivot(
                    $orderID,
                    [
                        'from_time' => $request->from_time,
                        'to_time' => $request->to_time,
                    ]
                );

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

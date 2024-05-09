<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\AssignTaskRequest;
use App\Models\Branch;
use App\Models\CareOrder;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
        $breadcrumbItems = [
            ['text' => trans('employee.employee'), 'url' => route('employee.index')],
            ['text' => trans('employee.assign_task'), 'url' => route('role.create')],
        ];
        if (!Branch::checkValid($branchID) || !User::checkValid($userID)) {
            abort(404);
        }

        $orders = CareOrder::where('branch_id', $branchID)
            ->orderBy('updated_at', 'desc')
            ->paginate(15)->withQueryString();

        return view('employee.assign-task', [
            'orders' => $orders,
            'userID' => $userID,
            'branchID' => $branchID,
            'breadcrumbItems' => $breadcrumbItems,
        ]);
    }

    public function assignTask(AssignTaskRequest $request, $userID, $orderID)
    {
        try {
            $user = User::findOrFail($userID);
            $user->assignTask()
                ->attach(
                    $orderID,
                    [
                        'from_time' => $request->from_time,
                        'to_time' => $request->to_time,
                    ]
                );

            return redirect()->back()->with('success', trans('employee.success'));
        } catch (ModelNotFoundException $e) {
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
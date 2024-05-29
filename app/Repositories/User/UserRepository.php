<?php

namespace App\Repositories\User;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Scopes\ActiveUserScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function getUserOption()
    {
        return $this->model->pluck('user_id', 'user_email');
    }

    public function getUserList($condition)
    {
        return $this->model->withoutGlobalScope(ActiveUserScope::class)
            ->with('role')
            ->where($condition)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constant.data_table.item_per_page'))->withQueryString();
    }

    public function storeUser($data, $isActive)
    {
        if (Gate::denies('create', User::class)) {
            return redirect()->route('user.create')->with('error', __('You do not have permission to create user'));
        }

        $this->model->fill($data);
        $this->model->is_active  = $isActive;
        $this->model->user_password = Hash::make($data['user_password']);

        if ($data['role_id'] === RoleEnum::ADMIN) {
            $this->model->is_admin = 1;
        }

        $this->model->save();
    }

    public function updateUser($data, $id, $isActive)
    {
        $user = $this->model->withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);

        if ($user->admin() && Gate::denies('updateAdmin', $user)) {
            return redirect()->route(
                'user.show',
                ['user' => $id]
            )->with(
                'error',
                __('You cannot update this user')
            );
        }

        if (Gate::denies('update', $user)) {
            return redirect()->route(
                'user.show',
                ['user' => $id]
            )->with(
                'error',
                __('You cannot update this user')
            );
        }

        $user->fill($data);

        $user->is_active  = $isActive;

        if ($user->role_id === RoleEnum::ADMIN) {
            $user->is_admin = 1;
        } else {
            $user->is_admin = 0;
        }

        // can't change admin role if you are admin and you are update yourself
        if (Auth::user()->user_id === $id && Auth::user()->role_id === RoleEnum::ADMIN) {
            $user->role_id = 1;
        }

        $user->save();
    }

    public function deleteUser($id)
    {
        $user = $this->model->withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);
        if ($user->admin() && Gate::denies('deleteAdmin', $user)) {
            flashMessage('error', __('You cannot delete yourself or admin'));

            return 'error';
        }

        if (!Gate::allows('delete', $user)) {
            flashMessage('error', __('You cannot delete yourself or admin'));

            return 'error';
        }

        $user->delete();
    }

    public function getDetailUser($id)
    {
        return $this->model->with('pets')->withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);
    }

    public function getEmployeeList($conditions = [])
    {
        return $this->model->with('branch')
            ->where('role_id', RoleEnum::EMPLOYEE)
            ->where($conditions)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constant.data_table.item_per_page'))
            ->withQueryString();
    }

    public function checkValid($id)
    {
        return $this->model->where('user_id', $id)->exists();
    }

    public function assignTask($id, $orderID, $fromDate, $toDate)
    {
        $user = $this->findOrFail($id);

        if (Gate::denies('assignTask', $user)) {
            throw new \Exception(trans('permission.update_fail'));
        }

        if ($this->isAssigned($orderID)) {
            throw new \Exception(trans('employee.already_assigned'));
        }

        if ($this->isOverlappingTask($fromDate, $toDate)) {
            throw new \Exception(trans('employee.overlapping'));
        }

        $user->assignTask()->attach($orderID, ['from_time' => $fromDate, 'to_time' => $toDate]);
    }

    public function isAssigned($orderID)
    {
        return DB::table('users')
            ->join('assign_task', 'users.user_id', '=', 'assign_task.user_id')
            ->where('assign_task.order_id', $orderID)
            ->select('assign_task.*')
            ->exists();
    }

    public function isOverlappingTask($fromTime, $toTime)
    {
        return $this->model
            ->assignTask()
            ->wherePivot('from_time', '<', $toTime)
            ->wherePivot('to_time', '>', $fromTime)
            ->exists();
    }

    public function unAssignTask($userID, $careOrderID)
    {
        $user = $this->findOrFail($userID);
        if (Gate::denies('unassignTask', $user)) {
            throw new \Exception(trans('permission.delete_fail'));
        }

        $user->assignTask()->detach($careOrderID);
    }

    public function updateAssignTask($userID, $orderID, $fromDate, $toDate)
    {
        $user = $this->findOrFail($userID);
        $user->assignTask()->updateExistingPivot(
            $orderID,
            [
                'from_time' => $fromDate,
                'to_time' => $toDate,
            ]
        );
    }

    public function updateProfile($data, $id)
    {
        $user = $this->model->withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);
        $user->fill($data);
        $user->update();
    }
}

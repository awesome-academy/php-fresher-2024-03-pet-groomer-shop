<?php

namespace App\Repositories\Branch;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Gate;

class BranchRepository extends BaseRepository implements BranchRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Branch::class;
    }

    public function getBranchOption($extra = false)
    {
        $options = $this->model->pluck('branch_id', 'branch_name');
        if ($extra) {
            $options[__('All')] = '';
        }

        return $options;
    }

    public function getBranchList()
    {
        return $this->model->paginate(config('constant.data_table.item_per_page'));
    }

    public function storeBranch($data)
    {
        if (Gate::denies('create', User::class)) {
            throw new \Exception(trans('permission.create_fail'));
        }

        $this->model->fill($data);
        $this->model->created_by = getUser()->user_id;
        $this->model->save();
    }

    public function updateBranch($data, $branchID)
    {
        $branch = $this->findOrFail($branchID);

        if (Gate::denies('update', $branch)) {
            throw new \Exception(trans('permission.update_fail'));
        }

        $branch->fill($data);
        $branch->update();
    }

    public function deleteBranch($branchID)
    {
        $branch = $this->findOrFail($branchID);
        if (Gate::denies('delete', $branch)) {
            throw new \Exception(trans('permission.delete_fail'));
        }

        $branch->delete();
    }

    public function checkValid($id)
    {
        return $this->model->where('branch_id', $id)->exists();
    }
}

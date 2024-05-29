<?php

namespace App\Repositories\Branch;

use App\Repositories\RepositoryInterface;

interface BranchRepositoryInterface extends RepositoryInterface
{
    public function getBranchOption($extra = false);

    public function getBranchList();

    public function storeBranch($data);

    public function updateBranch($data, $branchID);

    public function deleteBranch($branchID);

    public function checkValid($id);
}

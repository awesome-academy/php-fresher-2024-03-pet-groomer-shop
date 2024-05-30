<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Repositories\Branch\BranchRepositoryInterface;

class BranchController extends Controller
{
    protected $branchRepo;

    public function __construct(BranchRepositoryInterface $branchRepo)
    {
        $this->branchRepo = $branchRepo;
    }

    /**
     * Display a listing of branches.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $branches = $this->branchRepo->getBranchList();

        return response()->json($branches);
    }

    /**
     * Store a newly created branch in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BranchRequest $request)
    {
        $branch = $this->branchRepo->storeBranch($request->all());

        return response()->json($branch, 201);
    }

    /**
     * Display the specified branch.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $branch = $this->branchRepo->findOrFail($id);

        return response()->json($branch);
    }

    /**
     * Update the specified branch in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BranchRequest $request, $id)
    {
        $branch = $this->branchRepo->updateBranch($request->all(), $id);

        return response()->json($branch);
    }

    /**
     * Remove the specified branch from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->branchRepo->deleteBranch($id);

        return response()->json(['message' => 'Branch deleted successfully']);
    }
}

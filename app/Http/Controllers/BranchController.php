<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Repositories\Branch\BranchRepositoryInterface;
use Exception;

class BranchController extends Controller
{
    protected $branchRepo;

    public function __construct(BranchRepositoryInterface $branchRepo)
    {
        $this->branchRepo = $branchRepo;
    }

    public function index()
    {
        $branches = $this->branchRepo->getBranchList();

        return view('branch.index', ['branches' => $branches]);
    }

    public function create()
    {
        $breadcrumbItems = [
            ['text' => trans('branch.branch'), 'url' => route('branch.index')],
            ['text' => trans('branch.create'), 'url' => route('branch.create')],
        ];

        return view('branch.create', ['breadcrumbItems' => $breadcrumbItems]);
    }

    public function store(BranchRequest $request)
    {
        try {
            $this->branchRepo->storeBranch($request->all());

            return redirect()->route('branch.index')->with('success', trans('branch.create_success'));
        } catch (Exception $e) {
            return redirect()->route('branch.create')->with('error', $e->getMessage());
        }
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

    public function edit($id)
    {
        $breadcrumbItems = [
            [
                'text' => trans('branch.branch'),
                'url' => route('branch.index'),
            ],
            [
                'text' => trans('branch.update'),
                'url' => route(
                    'branch.edit',
                    ['branch' => $id]
                ),
            ],
        ];

        try {
            $branch = $this->branchRepo->findOrFail($id);

            return view(
                'branch.edit',
                [
                    'breadcrumbItems' => $breadcrumbItems,
                    'branch' => $branch,
                ]
            );
        } catch (Exception $e) {
            abort(404);
        }
    }

    public function update(BranchRequest $request, $id)
    {
        try {
            $this->branchRepo->updateBranch($request->all(), $id);

            return redirect()
                ->route('branch.index')
                ->with('success', trans('branch.update_success'));
        } catch (Exception $e) {
            return redirect()
                ->route(
                    'branch.edit',
                    ['branch' => $id]
                )
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->branchRepo->deleteBranch($id);
            flashMessage('success', trans('breed.delete_success'));
        } catch (Exception $e) {
            flashMessage('error', $e->getMessage());
        }
    }
}

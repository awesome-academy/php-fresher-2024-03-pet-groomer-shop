<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Exception;
use Illuminate\Support\Facades\Gate;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::paginate(config('constant.data_table.item_per_page'));

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
            if (Gate::denies('create', Branch::class)) {
                throw new Exception(trans('permission.create_fail'));
            }

            $branch = new Branch();

            $branch->fill($request->all());
            $branch->created_by = getUser()->user_id;
            $branch->save();

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
            $branch = Branch::findOrFail($id);

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
            $branch = Branch::findOrFail($id);

            if (Gate::denies('update', $branch)) {
                throw new Exception(trans('permission.update_fail'));
            }

            $branch->fill($request->all());
            $branch->update();

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
            $branch = Branch::findOrFail($id);
            if (Gate::denies('delete', $branch)) {
                throw new Exception(trans('permission.delete_fail'));
            }

            $branch->delete();
            flashMessage('success', trans('breed.delete_success'));
        } catch (Exception $e) {
            flashMessage('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $activeMenu = \App\Enums\StatusEnum::getTranslated();
        $ADMIN = \App\Enums\RoleEnum::ADMIN;

        return view('role.index', ['roles' => $roles, 'activeMenu' => $activeMenu, 'ADMIN' => $ADMIN]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbItems = [
            ['text' => trans('Role'), 'url' => route('role.index')],
            ['text' => trans('role.create'), 'url' => route('role.create')],
        ];

        return view('role.create', ['breadcrumbItems' => $breadcrumbItems]);
    }

    public function store(RoleRequest $request)
    {
        try {
            $role = new Role();
            $role->role_name = $request->role_name;
            $role->save();

            return redirect()->route('role.index')->with('success', trans('role.create_success'));
        } catch (Exception $e) {
            return redirect()->route('role.create')->with('error', $e->getMessage());
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
    public function update(RoleRequest $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->role_name = $request->input('role_name');
            $role->save();

            return redirect()->route('role.index')->with('success', trans('role.update_success'));
        } catch (Exception $e) {
            return redirect()->route('role.index')->with('error', $e->getMessage());
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
        try {
            if ((int) $id === RoleEnum::ADMIN) {
                return redirect()->route('role.index')->with('error', trans('role.not_found'));
            }

            $role = Role::findOrFail($id);

            $role->delete();

            return redirect()->route('role.index')->with('info', trans('role.delete_success'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('role.index')->with('error', trans('role.not_found'));
        }
    }
}

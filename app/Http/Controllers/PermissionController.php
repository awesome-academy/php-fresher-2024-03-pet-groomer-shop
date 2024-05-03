<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(config('constant.data_table.item_per_page'));

        return view('permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        $breadcrumbItems = [
            ['text' => trans('Permission'), 'url' => route('permission.index')],
            ['text' => trans('permission.create'), 'url' => route('permission.create')],
        ];

        return view('permission.create', ['breadcrumbItems' => $breadcrumbItems]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        try {
            $permission = new Permission();
            $permission->permission_name = $request->permission_name;
            $permission->save();

            // Dynamically update PermissionEnum class
            $enumFilePath = app_path('Enums/PermissionEnum.php');
            $enumFileContents = file_get_contents($enumFilePath);

            // Define the new permission constant
            $newConstant = 'public const '
                . strtoupper(str_replace('-', '_', $request->permission_name))
                . ' = "'
                . $request->permission_name
                . '";';

            // Append the new constant to the file contents
            $updatedEnumFileContents = preg_replace('/(\}\s*)$/', '    ' . $newConstant . "\n$1", $enumFileContents);

            // Write the updated contents back to the file
            file_put_contents($enumFilePath, $updatedEnumFileContents);

            return redirect()->route('permission.index')->with('success', trans('permission.create_success'));
        } catch (Exception $e) {
            return redirect()->route('permission.create')->with('error', $e->getMessage());
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
    public function update(PermissionRequest $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->permission_name = $request->input('permission_name');
            $permission->save();

            return redirect()->route('permission.index')->with('success', trans('permission.update_success'));
        } catch (Exception $e) {
            return redirect()->route('permission.index')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            $enumFilePath = app_path('Enums/PermissionEnum.php');
            $enumFileContents = File::get($enumFilePath);

            // Define the name of the constant to be removed
            $constantName = strtoupper(str_replace(
                '-',
                '_',
                $permission->permission_name
            ));

            // Remove the constant from the file contents
            $updatedEnumFileContents = preg_replace('/public\s+const\s+'
                . $constantName
                . '\s*=\s*".+?";\n*/', '', $enumFileContents);

            // Write the updated contents back to the file
            File::put($enumFilePath, $updatedEnumFileContents);

            return redirect()->route('permission.index')->with(
                'info',
                trans('permission.delete_success')
            );
        } catch (ModelNotFoundException $e) {
            return redirect()->route('permission.index')->with(
                'error',
                trans('permission.not_found')
            );
        }
    }

    public function attachRolePage($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $roles = Role::all();
            $breadcrumbItems = [
                ['text' => trans('Permission'), 'url' => route('permission.index')],
                [
                    'text' => trans('permission.attach_role'),
                    'url' => route('permission.attach-role-page', ['permission' => $permission['permission_id']]),
                ],
            ];

            return view('permission.attach-role', [
                'permission' => $permission,
                'roles' => $roles,
                'breadcrumbItems' => $breadcrumbItems,
            ]);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function attachRole(Request $request, $id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->roles()->sync($request->input('role_id', []));

            return redirect()->route(
                'permission.attach-role-page',
                ['permission' => $id]
            )->with(
                'success',
                trans('permission.attach_success')
            );
        } catch (Exception $e) {
            return redirect()->route(
                'permission.attach-role-page',
                ['permission' => $id]
            )->with(
                'error',
                $e->getMessage()
            );
        }
    }
}

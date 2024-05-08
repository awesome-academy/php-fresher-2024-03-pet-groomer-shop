<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\Models\Breed;
use App\Models\Role;
use App\Models\User;
use App\Scopes\ActiveUserScope;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::withoutGlobalScope(ActiveUserScope::class);
        $conditions = formatQuery($request->query());
        $users = $users->where($conditions)
            ->orderBy('created_at', 'desc')
            ->paginate(config('constant.data_table.item_per_page'))->withQueryString();

        [$roles] = $this->getOptions();
        $roles['all'] = '';

        $oldInput = $request->all();

        return view(
            'user.index',
            [
                'users' => $users,
                'roles' => $roles,
                'oldInput' => $oldInput,
            ]
        );
    }

    /**
     * Create a new user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        [$roles, $branches] = $this->getOptions();
        $breadcrumbItems = [
            ['text' => trans('User'), 'url' => route('user.index')],
            ['text' => trans('Create User'), 'url' => route('user.create')],
        ];

        return view('user.create', ['roles' => $roles, 'branches' => $branches, 'breadcrumbItems' => $breadcrumbItems]);
    }

    public function store(UserRequest $request)
    {
        try {
            $user = new User();
            if (Gate::denies('create', User::class)) {
                return redirect()->route('user.create')->with('error', __('You do not have permission to create user'));
            }

            $user->fill($request->all());
            $user->is_active  = $request->has('is_active') ? 1 : 0;
            $user->user_password = Hash::make($request->user_password);

            if ($request->role_id === RoleEnum::ADMIN) {
                $user->is_admin = 1;
            }

            $user->save();

            return redirect()->route('user.index')->with('success', __('User created successfully'));
        } catch (Exception $e) {
            return redirect()->route('user.create')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        [$roles, $branches, $breeds] = $this->getOptions();
        $user = User::with('pets')->withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);
        if ($user === null) {
            return abort(404);
        }

        $breadcrumbItems = [
            ['text' => trans('User'), 'url' => route('user.index')],
            ['text' => trans('User Detail'), 'url' => route('user.show', ['user' => $user->user_id])],
        ];

        return view('user.show', [
            'user' => $user,
            'roles' => $roles,
            'branches' => $branches,
            'breeds' => $breeds,
            'breadcrumbItems' => $breadcrumbItems,
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $data = $request->except(['user_email', 'username', 'user_password']);
            $user = User::getUserByID($id);

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
            $user->is_active  = $request->has('is_active') ? 1 : 0;

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

            return redirect()->route('user.show', ['user' => $id])->with('success', __('User updated successfully'));
        } catch (Exception $e) {
            return redirect()->route('user.show', ['user' => $id])->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::withoutGlobalScope(ActiveUserScope::class)->findOrFail($id);
            if ($user->admin() && Gate::denies('deleteAdmin', $user)) {
                flashMessage('error', __('You cannot delete yourself or admin'));

                return 'error';
            }

            if (!Gate::allows('delete', $user)) {
                flashMessage('error', __('You cannot delete yourself or admin'));

                return 'error';
            }

            $user->delete();

            flashMessage('success', __('User deleted successfully'));

            return 'success';
        } catch (ModelNotFoundException $e) {
            flashMessage('error', $e->getMessage());
        }
    }

    private function getOptions()
    {
        $roles = Role::pluck('role_id', 'role_name');
        if ($roles->isEmpty()) {
            $roles = [];
        }

        $branches = Branch::pluck('branch_id', 'branch_name');

        if ($branches->isEmpty()) {
            $branches = [];
        }

        $breeds = Breed::pluck('breed_id', 'breed_name');

        return [$roles, $branches, $breeds];
    }
}

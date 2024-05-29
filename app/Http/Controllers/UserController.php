<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\UserSearchRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\Branch\BranchRepositoryInterface;
use App\Repositories\Breed\BreedRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $userRepo;
    protected $branchRepo;
    protected $breedRepo;
    protected $roleRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        BranchRepositoryInterface $branchRepo,
        BreedRepositoryInterface $breedRepo,
        RoleRepositoryInterface $roleRepo
    ) {
        $this->userRepo = $userRepo;
        $this->branchRepo = $branchRepo;
        $this->breedRepo = $breedRepo;
        $this->roleRepo = $roleRepo;
    }

    public function index(UserSearchRequest $request): View
    {
        $conditions = formatQuery($request->query());
        $users = $this->userRepo->getUserList($conditions);

        [$roles] = $this->getOptions();
        $roleEnum = array_flip(\App\Enums\RoleEnum::getConstants());
        $roles[__('All')] = '';

        return view(
            'user.index',
            [
                'users' => $users,
                'oldInput' => $request->all(),
                'roles' => $roles,
                'roleEnum' => $roleEnum,
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

        return view(
            'user.create',
            [
                'roles' => $roles,
                'branches' => $branches,
                'breadcrumbItems' => $breadcrumbItems,
            ]
        );
    }

    public function store(UserRequest $request)
    {
        try {
            $user = new User();
            $isActive = $request->has('is_active') ? 1 : 0;
            $this->userRepo->storeUser($request->all(), $isActive);
            uploadImg($request, 'user_avatar', $user);

            return redirect()->route('user.index')->with('success', __('User created successfully'));
        } catch (Exception $e) {
            return redirect()->route('user.create')->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        [$roles, $branches, $breeds] = $this->getOptions();
        $user = $this->userRepo->getDetailUser($id);
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
            $isActive = $request->has('is_active') ? 1 : 0;
            $user = $this->userRepo->updateUser($data, $id, $isActive);
            uploadImg($request, 'user_avatar', $user);

            return redirect()->route('user.show', ['user' => $id])->with('success', __('User updated successfully'));
        } catch (Exception $e) {
            return redirect()->route('user.show', ['user' => $id])->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->userRepo->deleteUser($id);

            flashMessage('success', __('User deleted successfully'));

            return 'success';
        } catch (ModelNotFoundException $e) {
            flashMessage('error', $e->getMessage());
        }
    }

    private function getOptions()
    {
        $roles = $this->roleRepo->getRoleOption();

        $branches = $this->branchRepo->getBranchOption();

        $breeds = $this->breedRepo->getBreedOption();

        return [$roles, $branches, $breeds];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Breed;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $users = User::all();

        return view(
            'user.index',
            ['users' => $users]
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

        return view('user.create', ['roles' => $roles, 'branches' => $branches]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id The ID of the user to be displayed
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response The view for the user's details, or a 404 error if the user is not found
     */
    public function show($id)
    {
        [$roles, $branches, $breeds] = $this->getOptions();

        $user = User::find($id)->with('pets')->first();
        if ($user === null) {
            return abort(404);
        }

        return view('user.show', ['user' => $user, 'roles' => $roles, 'branches' => $branches, 'breeds' => $breeds]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

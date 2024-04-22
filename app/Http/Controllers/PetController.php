<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pet.create');
    }

    public function store(PetRequest $request, int $userID)
    {
        try {
            $data = $request->except('_token');
            $data['user_id'] = $userID;
            $data['is_active'] = $request->has('is_active') ? 1 : 0;

            DB::table('pets')->insert($data);

            return redirect()->route('user.show', $userID)->with('success', __('Pet created successfully'));
        } catch (Exception $exception) {
            return redirect()->route('user.show', $userID)->with('error', $exception->getMessage());
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
        return view('pet.show');
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
    public function update(PetRequest $request, $id, $userID)
    {
        try {
            $data = $request->except(['_token', '_method']);

            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            DB::table('pets')->where('pet_id', $id)->update($data);

            return redirect()->route('user.show', $userID)->with('success', __('Pet updated successfully'));
        } catch (Exception $exception) {
            return redirect()->route('user.show', $userID)->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $userID)
    {
        try {
            DB::table('pets')->where('pet_id', $id)->delete();

            return redirect()->route('user.show', $userID)->with('success', __('Pet deleted successfully'));
        } catch (Exception $exception) {
            return redirect()->route('user.show', $userID)->with('error', $exception->getMessage());
        }
    }
}

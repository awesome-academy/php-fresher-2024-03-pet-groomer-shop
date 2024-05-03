<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::paginate(10)->withQueryString();

        return view('coupons.index', ['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons.create');
    }

    public function store(CouponRequest $request)
    {
        try {
            if (Gate::denies('create', User::class)) {
                throw new Exception(trans('coupon.create_error'));
            }

            $coupon = new Coupon();
            $coupon->fill($request->all());
            $coupon->created_by = Auth::user()->user_id;
            $coupon->is_active  = $request->has('is_active') ? 1 : 0;
            $coupon->save();

            return redirect()->route('coupon.index')->with('success', __('coupon.create_success'));
        } catch (Exception $e) {
            return redirect()->route('coupon.create')->with('error', $e->getMessage());
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
        try {
            $coupon = Coupon::findOrFail($id);

            return view('coupons.edit', ['coupon' => $coupon]);
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
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
        try {
            $coupon = Coupon::findOrFail($id);
            if (Gate::denies('update', $coupon)) {
                throw new Exception(trans('coupon.update_error'));
            }

            $coupon->fill($request->all());
            $coupon->is_active  = $request->has('is_active') ? 1 : 0;
            $coupon->save();

            return redirect()->route('coupon.index')->with('success', __('coupon.update_success'));
        } catch (ModelNotFoundException $exception) {
            abort(404);
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
            $coupon = Coupon::findOrFail($id);
            if (Gate::denies('delete', $coupon)) {
                throw new Exception(trans('coupon.delete_error'));
            }

            $coupon->delete();
            flashMessage('success', __('coupon.delete_success'));
        } catch (Exception $exception) {
            flashMessage('error', $exception->getMessage());
        }
    }
}

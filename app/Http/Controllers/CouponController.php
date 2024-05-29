<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponRepo;

    public function __construct(CouponRepositoryInterface $couponRepo)
    {
        $this->couponRepo = $couponRepo;
    }

    public function index()
    {
        $coupons = $this->couponRepo->getCouponList();

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
            $isActive = $request->has('is_active') ? 1 : 0;
            $this->couponRepo->storeCoupon($request->all(), $isActive);

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
            $coupon = $this->couponRepo->findOrFail($id);

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
            $isActive = $request->has('is_active') ? 1 : 0;
            $this->couponRepo->updateCoupon($request->all(), $isActive, $id);

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
            $this->couponRepo->deleteCoupon($id);
            flashMessage('success', __('coupon.delete_success'));
        } catch (Exception $exception) {
            flashMessage('error', $exception->getMessage());
        }
    }
}

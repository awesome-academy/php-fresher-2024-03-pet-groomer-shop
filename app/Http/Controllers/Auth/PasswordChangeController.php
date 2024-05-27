<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::findOrFail(getUser()->user_id);

        if (!Hash::check($request->old_password, $user->user_password)) {
            return redirect()->back()->with('error', trans('auth.old_password_wrong'));
        }

        $user->user_password = Hash::make($request->password);
        $user->save();

        return redirect()->route('customer-profile.index')->with('success', trans('auth.change_success'));
    }
}

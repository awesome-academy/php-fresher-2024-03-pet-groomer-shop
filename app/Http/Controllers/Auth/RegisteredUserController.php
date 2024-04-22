<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_first_name' => ['required', 'string', 'min:2', 'max:255'],
            'user_last_name' => ['required', 'string', 'min:2', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'unique:users', 'max:255', 'unique:users'],
            'user_password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_gender' => ['required', 'in:0,1,2'],
            'username' => ['required', 'string', 'min:3', 'unique:users', 'max:255'],
        ]);

        $user = User::create([
            'user_first_name' => $request->user_first_name,
            'user_last_name' => $request->user_last_name,
            'user_email' => $request->user_email,
            'user_gender' => $request->user_gender,
            'user_password' => Hash::make($request->user_password),
            'username' => $request->username,
            'role_id' => Config::get('constant.roles.customer'),
            'is_active' => Config::get('constant.status.active'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

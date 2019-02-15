<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('backend.login');
    }

    public function showRegisterForm()
    {
        return view('backend.signup');
    }

    public function register(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | string | min:6 | max:50',
            'username' => 'required | alpha_dash | min:6 | unique:users',
            'email' => 'required | email | unique:users',
            'password' => 'required | confirmed',
            'terms' => 'accepted',
        ];

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Toastr::success('You have successfully add a new Staff!', 'Success');
        return redirect()->route('backend.dashboard');

    }

    public function login(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
          'email' => 'required | email',
          'password' => 'required',
        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $remember = $request->input('remember');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember))
        {
            Toastr::success('You have successfully Login!', 'Success');
            return redirect()->route('backend.dashboard');

        } else {
            return redirect()->back()->withInput()->with('error', 'Your Email and Password doesnt match!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }



}

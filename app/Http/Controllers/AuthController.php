<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('home');
        } else {
            session()->flash('error', 'Invalid email or password combination');
            return redirect(route('login'));
        }
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        return $request;
    }
}

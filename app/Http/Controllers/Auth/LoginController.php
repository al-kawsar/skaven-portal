<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Inertia\Inertia;

class LoginController extends Controller
{

    public function showFormLogin()
    {
        return Inertia::render('Auth/Login');
    }
    public function doLogin(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (!auth()->attempt($credentials))
                throw new \Exception('Email atau Password Salah!', 400);

            return response()->json([
                'message' => 'Login Successfull'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}

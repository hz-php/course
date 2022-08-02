<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;

class UserAuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([
           'user' => $user,
           'token' => $token
        ]);
    }

    public function login(UserLoginRequest $request)
    {
        $data = $request->all();
        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Некоректные данные, попробуйте ещё']);
        }
        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);
    }
}

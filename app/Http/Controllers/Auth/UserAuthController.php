<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class UserAuthController extends Controller
{
    /*
     * Создаём пользователя с новым токеном
     * Также входные данные валидируются в реквесте UserRegisterRequest
     */
    public function register(UserRegisterRequest $request)
    {
        $data = $request->all();
//        dd($request);
        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    /*
     * Метод атутентификации пользователя
     */
    public function login(UserLoginRequest $request)
    {
        $data = $request->all();

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Введены неправильные данные']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);
    }

}

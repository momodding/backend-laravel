<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(RegistrationRequest $request)
    {
        $request = $request->toArray();
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $request['type'] = config('constant.user_type.normal');

        $user = User::create($request);
        $token = $user->createToken(config('constant.passport_type.password_grant'))->accessToken;

        $response = ['accessToken' => $token];
        $cookie = Cookie::make('accessToken', $token, 3600);
        return $this->successResponse($response, "Registration success!")->cookie($cookie);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->orWhere('email', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken(config('constant.passport_type.password_grant'))->accessToken;
                $response = ['accessToken' => $token];

                $cookie = Cookie::make('accessToken', $token, 3600);
                return $this->successResponse($response, "Login success!")->cookie($cookie);
            } else {
                return $this->errorResponse([], "Please check your username or password!", 400);
            }
        } else {
            return $this->errorResponse([], "Please check your username or password!", 400);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return $this->successResponse(null, "'Logout' success!");
    }
}

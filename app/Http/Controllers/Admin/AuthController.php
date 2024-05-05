<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @throws InvalidCredentialsException
     */
    public function login(AuthRequest $request): AuthResource
    {
        if (Auth::attempt($request->validated())) {
            $token = $request->user()->createToken(config('auth.token_name'));
            $user = Auth::user();
            $user['token'] = $token->plainTextToken;
            return AuthResource::make($user);
        }

        throw new InvalidCredentialsException();
    }

    public function logout(): void
    {
        Auth::logout();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\PasswordIncorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserUpdatePawwsordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\AuthResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $user->load('company');
            App::setLocale(($user->company) ? $user->company->lang->value : config('app.locale'));

            return AuthResource::make($user);
        }

        throw new InvalidCredentialsException();
    }

    /**
     * @param UserUpdateRequest $request
     * @return AuthResource
     */
    public function update(UserUpdateRequest $request): AuthResource
    {
        Auth::user()->update($request->validated());

        return AuthResource::make(Auth::user());
    }

    /**
     * @throws PasswordIncorrectException
     */
    public function updatePassword(UserUpdatePawwsordRequest $request): JsonResponse
    {
        if(Hash::check($request->input('password_old'), Auth::user()->password))
        {
            $password = Hash::make($request->input('password_new'));

            Auth::user()->update(['password' => $password]);

            Auth::user()->tokens()->delete();

            return new JsonResponse(['id' => Auth::user()->getKey()]);
        }

        throw new PasswordIncorrectException();
    }


    /**
     * @return \Illuminate\Http\Response
     */
    public function logout(): \Illuminate\Http\Response
    {
        Auth::user()->tokens()->delete();

        return response()->noContent();
    }
}

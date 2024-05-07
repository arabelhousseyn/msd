<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PasswordIncorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdatePawwsordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $users = User::latest('created_at')->paginate();

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request): UserResource
    {
        $path = null;

        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('user', 'public');
            $path = config('app.url') . Storage::url($path);
        }

        $password = Hash::make($request->input('password'));

        $user = User::create(array_merge($request->except(['avatar', 'password']), ['password' => $password, 'avatar' => $path]));

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $path = $user->avatar;

        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('company', 'public');
            $path = config('app.url') . Storage::url($path);
        }

        $user->update(array_merge($request->except('avatar'), ['avatar' => $path]));

        return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return new JsonResponse(['id' => $user->getKey()]);
    }

    /**
     * @throws PasswordIncorrectException
     */
    public function updatePassword(UserUpdatePawwsordRequest $request, User $user): JsonResponse
    {
        if(Hash::check($request->input('password_old'), $user->password))
        {
            $password = Hash::make($request->input('password_new'));

            $user->update(['password' => $password]);

            $user->tokens()->delete();

            return new JsonResponse(['id' => $user->getKey()]);
        }

        throw new PasswordIncorrectException();
    }

    public function usersByCompany(Company $company): JsonResource
    {
        $users = User::where('company_id', $company->getKey())->where('id', '!=', Auth::id())->get();

        return UserResource::collection($users);
    }
}

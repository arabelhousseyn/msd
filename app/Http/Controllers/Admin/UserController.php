<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PasswordIncorrectException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdatePawwsordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index(Request $request): JsonResource
     {
         $query = QueryBuilder::for(User::class)
             ->allowedFilters([
                 AllowedFilter::scope('search') // Add the scope filter here
             ])
             ->defaultSort('-first_name'); // Default sorting by created_at in descending order
     
         // Apply company ID filter if provided
         if ($request->has('company_id')) {
             $query->where('company_id', $request->input('company_id'))
                   ->where('id', '!=', Auth::id());
         } else {
             $query->where('id', '<>', Auth::id());
         }
     
         // Apply pagination
         $users = $query->paginate(20);
     
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

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('user', 'public');
            $path = config('app.url') . Storage::url($path);
        } else {
            $avatar = Avatar::create($request->input('first_name') . ' ' . $request->input('last_name'))
                ->setDimension(100)
                ->setFontSize(50)
                ->save('storage/' . uniqid() . '.jpg');

            $path = config('app.url') . '/' . $avatar->basePath();
        }


        $password = Hash::make($request->input('password'));

        $user = User::create(array_merge($request->except(['avatar', 'password', 'role']), ['password' => $password, 'avatar' => $path]));

        if($request->has('role'))
        {
            $user->assignRole($request->input('role'));
        }

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
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

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('company', 'public');
            $path = config('app.url') . Storage::url($path);
        }

        $position = $request->input('is_admin') == 1 ? null : $request->input('position');

        if($request->input('is_admin') == 1)
        {
            $user->roles()->detach();
        }else{
            if($request->has('role'))
            {
                $user->syncRoles([$request->input('role')]);
            }
        }

        $user->update(array_merge($request->except(['avatar', 'position']), ['avatar' => $path, 'position' => $position]));

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
        if (Hash::check($request->input('password_old'), $user->password)) {
            $password = Hash::make($request->input('password_new'));

            $user->update(['password' => $password]);

            $user->tokens()->delete();

            return new JsonResponse(['id' => $user->getKey()]);
        }

        throw new PasswordIncorrectException();
    }

    public function notifications(User $user): JsonResource
    {
        $notifications = $user->notifications()->latest()->get();

        return NotificationResource::collection($notifications);
    }
}

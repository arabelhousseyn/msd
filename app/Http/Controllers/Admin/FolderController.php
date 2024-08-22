<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderCreateRequest;
use App\Http\Requests\FolderUpdateRequest;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use App\Support\FolderNotificationBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
       // Define the special user ID
    $specialUserId = '9ca116d5-8060-467c-ad6e-9cff51d19c13';
    $manager = '9cc8470c-3e4b-4f4c-9122-c374399556a2';

    // Check if user_id is provided in the request
    if ($request->has('user_id')) {
        $userId = $request->input('user_id');

        // Check if the user_id matches the special user ID
        if ($userId === $specialUserId || $userId === $manager) {
            // If the user is the special user, get all data
            $folders = QueryBuilder::for(Folder::class)
                ->allowedFilters(['is_archived', 'status', AllowedFilter::scope('trashed'), AllowedFilter::scope('title')])
                ->latest('updated_at')
                ->with('user')
                ->paginate(10);;
        } else {
            // For other users, apply the where conditions
            $folders = QueryBuilder::for(Folder::class)
                ->allowedFilters(['is_archived', 'status', AllowedFilter::scope('trashed'), AllowedFilter::scope('title')])
                ->latest('updated_at')
                ->where(function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                          ->orWhere('user_id', $userId);
                })
                ->paginate(10);
        }
    } else {
        // Handle cases where user_id is not provided in the request
        $folders = QueryBuilder::for(Folder::class)
            ->allowedFilters(['is_archived', 'status', AllowedFilter::scope('trashed'), AllowedFilter::scope('title')])
            ->latest('updated_at')
            ->with('user')
            ->paginate(10);
    }

        return FolderResource::collection($folders);
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
    public function store(FolderCreateRequest $request): FolderResource
    {
        $folder = Folder::create($request->validated());

        $folder->refresh();

        (new FolderNotificationBuilder($folder, 'create'))->send();

        return FolderResource::make($folder);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder): FolderResource
    {
        return FolderResource::make($folder->load(['creator']));
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
    public function update(FolderUpdateRequest $request, Folder $folder): FolderResource
    {
        $user_id = $folder->user_id;
        $status = $folder->status->value;

        $folder->update($request->validated());

        $folder->refresh();

        if($user_id !== $folder->user_id)
        {
            (new FolderNotificationBuilder($folder, 'assign'))->send();
        }

        if($status !== $folder->status->value)
        {
            (new FolderNotificationBuilder($folder, 'status'))->send();
        }

        return FolderResource::make($folder);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder): JsonResource
    {
        $folder->delete();

        return JsonResource::make(['id' => $folder->getKey()]);
    }

    public function forceDestroy($folder_id): JsonResource
    {
        $folder = Folder::withTrashed()->find($folder_id);

        $folder->forceDelete();

        return JsonResource::make(['id' => $folder->getKey()]);
    }
}

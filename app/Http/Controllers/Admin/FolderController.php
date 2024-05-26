<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderCreateRequest;
use App\Http\Requests\FolderUpdateRequest;
use App\Http\Resources\FolderResource;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        if($request->has('user_id')){
            $folders = Folder::latest('created_at')->where('user_id', $request->input('user_id'))->get();
        }else{
            $folders = Folder::latest('created_at')->with('user')->get();
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

        return FolderResource::make($folder);
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder): FolderResource
    {
        return FolderResource::make($folder);
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
        $folder->update($request->validated());

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
}

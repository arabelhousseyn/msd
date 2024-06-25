<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentCreateRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Support\FolderNotificationBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResource
    {
        if($request->has('folder_id'))
        {
            $documents = QueryBuilder::for(Document::class)
                ->allowedFilters([
                    AllowedFilter::scope('title'),
                ])
                ->latest('created_at')
                ->where('folder_id', $request->input('folder_id'))
                ->get();
        }else{
            $documents = QueryBuilder::for(Document::class)
                ->allowedFilters([
                    AllowedFilter::scope('title'),
                ])
                ->latest('created_at')
                ->get();
        }

        return DocumentResource::collection($documents);
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
    public function store(DocumentCreateRequest $request): JsonResource
    {
        $path = null;

        if($request->hasFile('file')){
            $path = $request->file('file')->store('document', 'public');
            $path = config('app.url') . Storage::url($path);
        }

        $document = Document::create(array_merge($request->validated(), ['url' => $path]));

        if($request->hasFile('file'))
        {
            (new FolderNotificationBuilder($document->folder()->first(), 'document', $document, $request->file('file')))->send();
        }

        return DocumentResource::make($document);
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
    public function update(DocumentUpdateRequest $request, Document $document): JsonResource
    {
        $path = $document->url;

        if($request->hasFile('file')){
            $path = $request->file('file')->store('document', 'public');
            $path = config('app.url') . Storage::url($path);
        }

        $document->update(array_merge($request->validated(), ['url' => $path]));

        return DocumentResource::make($document);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document): JsonResource
    {
        $document->delete();

        return JsonResource::make(['id' => $document->getKey()]);
    }
}

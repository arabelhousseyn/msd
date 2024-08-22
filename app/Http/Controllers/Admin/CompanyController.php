<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        $companies = Company::where('is_external', true)->latest('created_at')->get();

        return CompanyResource::collection($companies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCompanyRequest $request): CompanyResource
    {
        $path = null;

        if($request->hasFile('logo')){
            $path = $request->file('logo')->store('company', 'public');
            $path = config('app.url') . Storage::url($path);
        }
        $company = Company::create(array_merge($request->except('logo'), ['logo' => $path , 'is_external' => true]));

        return CompanyResource::make($company);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company): CompanyResource
    {
        return CompanyResource::make($company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company): CompanyResource
    {
        $path = $company->logo;

        if($request->hasFile('logo')){
            $path = $request->file('logo')->store('company', 'public');
            $path = config('app.url') . Storage::url($path);
        }

        $company->update(array_merge($request->except(['logo','directions']), ['logo' => $path]));

        return CompanyResource::make($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return new JsonResponse(['id' => $company->getKey()]);
    }

     // update the directions of the company
    public function updateDirections(Request $request, $id)
    {
        $company = Company::find($id);
        $directions = $request->input('directions');

        // Validate directions input
        //$validatedData = $request->validate([
        //    'directions' => 'required|array',
        //    'directions.*.title' => 'required|string',
        //    'directions.*.name' => 'required|string',
        //    'directions.*.img' => 'nullable|string',
       // ]);

        // Override the current directions
        $company->directions = $directions;
        $company->save();

        return response()->json(['message' => 'Directions updated successfully','id'=>$id,'directions'=>$directions]);
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstallerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateCompanyRequest $request): CompanyResource
    {
        $path = $request->file('logo')->store('company', 'public');
        $path = config('app.url') . Storage::url($path);

        $company = Company::create(array_merge($request->except('logo'), ['logo' => $path]));

        return CompanyResource::make($company);
    }
}

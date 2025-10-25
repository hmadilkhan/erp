<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $companies = Company::with(['country', 'city', 'branches'])->get();
        return $this->sendResponse($companies, 'Companies retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'logo' => 'nullable|string',
            'ntn' => 'nullable|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $company = Company::create($request->all());
        $company->load(['country', 'city', 'branches']);
        return $this->sendResponse($company, 'Company created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $company = Company::with(['country', 'city', 'branches'])->find($id);

        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse($company, 'Company retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $company = Company::find($id);

        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'logo' => 'nullable|string',
            'ntn' => 'nullable|string|max:50',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $company->update($request->all());
        $company->load(['country', 'city', 'branches']);
        return $this->sendResponse($company, 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $company = Company::find($id);

        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        $company->delete();
        return $this->sendResponse(null, 'Company deleted successfully.');
    }
}

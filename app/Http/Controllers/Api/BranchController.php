<?php

namespace App\Http\Controllers\Api;

use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $branches = Branch::with(['company', 'country', 'city', 'terminals', 'users'])->get();
        return $this->sendResponse($branches, 'Branches retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
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

        $branch = Branch::create($request->all());
        $branch->load(['company', 'country', 'city', 'terminals', 'users']);
        return $this->sendResponse($branch, 'Branch created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $branch = Branch::with(['company', 'country', 'city', 'terminals', 'users'])->find($id);

        if (is_null($branch)) {
            return $this->sendError('Branch not found.');
        }

        return $this->sendResponse($branch, 'Branch retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $branch = Branch::find($id);

        if (is_null($branch)) {
            return $this->sendError('Branch not found.');
        }

        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
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

        $branch->update($request->all());
        $branch->load(['company', 'country', 'city', 'terminals', 'users']);
        return $this->sendResponse($branch, 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $branch = Branch::find($id);

        if (is_null($branch)) {
            return $this->sendError('Branch not found.');
        }

        $branch->delete();
        return $this->sendResponse(null, 'Branch deleted successfully.');
    }
}

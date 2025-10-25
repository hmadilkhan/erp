<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $countries = Country::with(['cities'])->get();
        return $this->sendResponse($countries, 'Countries retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $country = Country::create($request->all());
        return $this->sendResponse($country, 'Country created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $country = Country::with(['cities'])->find($id);

        if (is_null($country)) {
            return $this->sendError('Country not found.');
        }

        return $this->sendResponse($country, 'Country retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $country = Country::find($id);

        if (is_null($country)) {
            return $this->sendError('Country not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $country->update($request->all());
        return $this->sendResponse($country, 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $country = Country::find($id);

        if (is_null($country)) {
            return $this->sendError('Country not found.');
        }

        $country->delete();
        return $this->sendResponse(null, 'Country deleted successfully.');
    }
}

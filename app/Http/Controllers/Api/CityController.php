<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $cities = City::with(['country'])->get();
        return $this->sendResponse($cities, 'Cities retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $city = City::create($request->all());
        $city->load('country');
        return $this->sendResponse($city, 'City created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $city = City::with(['country'])->find($id);

        if (is_null($city)) {
            return $this->sendError('City not found.');
        }

        return $this->sendResponse($city, 'City retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $city = City::find($id);

        if (is_null($city)) {
            return $this->sendError('City not found.');
        }

        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $city->update($request->all());
        $city->load('country');
        return $this->sendResponse($city, 'City updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $city = City::find($id);

        if (is_null($city)) {
            return $this->sendError('City not found.');
        }

        $city->delete();
        return $this->sendResponse(null, 'City deleted successfully.');
    }
}

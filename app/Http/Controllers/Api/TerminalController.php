<?php

namespace App\Http\Controllers\Api;

use App\Models\Terminal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerminalController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $terminals = Terminal::with(['branch'])->get();
        return $this->sendResponse($terminals, 'Terminals retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|unique:terminals,mac_address',
            'serial_no' => 'required|string|unique:terminals,serial_no',
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $terminal = Terminal::create($request->all());
        $terminal->load('branch');
        return $this->sendResponse($terminal, 'Terminal created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $terminal = Terminal::with(['branch'])->find($id);

        if (is_null($terminal)) {
            return $this->sendError('Terminal not found.');
        }

        return $this->sendResponse($terminal, 'Terminal retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $terminal = Terminal::find($id);

        if (is_null($terminal)) {
            return $this->sendError('Terminal not found.');
        }

        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|unique:terminals,mac_address,' . $id,
            'serial_no' => 'required|string|unique:terminals,serial_no,' . $id,
            'status' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $terminal->update($request->all());
        $terminal->load('branch');
        return $this->sendResponse($terminal, 'Terminal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $terminal = Terminal::find($id);

        if (is_null($terminal)) {
            return $this->sendError('Terminal not found.');
        }

        $terminal->delete();
        return $this->sendResponse(null, 'Terminal deleted successfully.');
    }
}

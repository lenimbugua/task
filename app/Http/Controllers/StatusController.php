<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Status;
use App\Http\Resources\StatusResource;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Status $status)
    {
        $statuses = Status::whereNull('deleted_at')->get();

        return StatusResource::collection($statuses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStatusRequest $request)
    {
        $status = Status::create($request->validated());

        return StatusResource::make($status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return StatusResource::make($status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        return StatusResource::make($status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = Status::find($id);

        if (!$status || !$status->exists()) {
            return response()->json(['message' => 'Status not found'], 404);
        }
        $status->forceFill(['deleted_at' => now()])->save();

        return response()->json(['message' => 'Status soft-deleted', 'deleted_at' => $status->deleted_at], 200);
    }
}

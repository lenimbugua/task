<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Status;
use App\Http\Resources\TaskResource;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::whereNull('deleted_at')->get();

        return TaskResource::collection($task);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Get the status to which the task belongs
        $status = Status::find($request->status_id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        // Associate the task with status
        $task = $status->tasks()->create($request->validated());
        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Get the status to which the task belongs
        $status = Status::find($request->status_id);

        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $task->status()->associate($status); // Update the foreign key on the task model
        $task->update($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task || !$task->exists()) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->forceFill(['deleted_at' => now()])->save();

        return response()->json(['message' => 'Task soft-deleted', 'deleted_at' => $task->deleted_at], 200);
    }
}

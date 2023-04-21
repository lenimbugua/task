<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserTaskRequest;
use App\Http\Requests\UpdateUserTaskRequest;
use App\Http\Requests\UpdateUserTaskStatusRequest;
use App\Models\UserTask;
use App\Models\Status;
use Carbon\Carbon;


use App\Http\Resources\UserTaskResource;

class UserTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        $userTasks = UserTask::where('user_id', $user_id)->get();
        return UserTaskResource::collection($userTasks);
    }

    /**
     * Display a listing of user-tasks.
     */
    public function listUserTasks($user_id)
    {
        $userTasks = UserTask::where('user_id', $user_id)->get();
        return UserTaskResource::collection($userTasks);
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
    public function store(StoreUserTaskRequest $request)
    {
        $userTask = UserTask::create($request->validated());

        return UserTaskResource::make($userTask);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserTask $userTask)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserTaskRequest $request, UserTask $userTask)
    {
        $userTask->update($request->validated());

        return UserTaskResource::make($userTask);
    }

    /**
     * Update status of user-task.
     */

    public function updateTaskStatus(UpdateUserTaskStatusRequest $request)
    {
        $userTask = UserTask::find($request->user_task_id);

        // Check if the task exists
        if (!$userTask) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $status = Status::find($request->status_id);

        // Check if the task exists
        if (!$status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        // Check if the task is expired
        if (Carbon::parse($userTask->due_date)->isPast()) {
            return response()->json(['message' => 'Task expired'], 400);
        }

        // Update the task status
        $userTask->status_id = $request->status_id;
        $userTask->save();

        // Associate the status record with the updated task record
        $status = Status::find($request->status_id);
        $userTask->status()->associate($status);
        $userTask->save();

        return response()->json(['message' => 'Task status updated'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTask $userTask)
    {
        //
    }
}

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
        $userTasks = UserTask::where('user_id', $user_id)
            ->whereNull('deleted_at')
            ->get();
        return UserTaskResource::collection($userTasks);
    }

    /**
     * Display a listing of user-tasks.
     */
    public function listUserTasks($user_id)
    {
        $userTasks = UserTask::where('user_id', $user_id)
            ->whereNull('deleted_at')
            ->get();
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

        return response()->json(['message' => 'Task status updated'], 200);
    }

    /**
     * Update start time of user-task.
     */

    public function startTask(UpdateUserTaskStatusRequest $request)
    {
        $userTask = UserTask::find($request->user_task_id);

        // Check if the task exists
        if (!$userTask) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Update the task start time
        $userTask->start_time = Carbon::now();
        $userTask->save();



        return response()->json(['message' => 'Task started successfully'], 200);
    }

    /**
     * Update user-task end time of user-task.
     */

    public function endTask(UpdateUserTaskStatusRequest $request)
    {
        $userTask = UserTask::find($request->user_task_id);

        // Check if the task exists
        if (!$userTask) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Update the task start time and remarks
        $userTask->end_time = Carbon::now();
        $userTask->remarks = $request->remarks;
        $userTask->save();



        return response()->json(['message' => 'Task ended successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userTask = UserTask::find($id);

        if (!$userTask || !$userTask->exists()) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $userTask->forceFill(['deleted_at' => now()])->save();

        return response()->json(['message' => 'Task soft-deleted', 'deleted_at' => $userTask->deleted_at], 200);
    }
}

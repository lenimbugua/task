<?php

namespace App\Http\Controllers;

use App\Models\UserTask;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;





class StatsController extends Controller
{
    // Total user_tasks
    public function countUserTasks()
    {
        $totalCount = DB::table('user_tasks')->count();
        return response()->json(['count' => $totalCount]);
    }

    //total users
    public function countUsers()
    {
        $totalCount = DB::table('users')->count();
        return response()->json(['count' => $totalCount]);
    }

    //count status user-task
    public function countStatus($status)
    {
        $totalCount = UserTask::whereHas('status', function ($query) {
            $query->where('name', 'started');
        })->count();
        return response()->json(['count' => $totalCount]);
    }

    //count expired user_tasks
    public function countExpiredUserTasks()
    {
        $now = Carbon::now();
        $count = UserTask::where('due_date', '<', $now)
            ->whereHas('status', function ($query) {
                $query->where('name', '<>', 'completed');
            })->count();

        return response()->json(['count' => $count]);
    }

    //Total Count of Expired User Tasks with Incomplete Status for a given past num of days
    public function countPastExpiredUserTasks()
    {
        $days = 7; // number of past days to count user_tasks for
        $date = Carbon::now()->subDays($days);

        $results = DB::table('user_tasks')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $date)
            ->groupBy('date')
            ->get();


        return response()->json(['data' => $results]);
    }

    //
}

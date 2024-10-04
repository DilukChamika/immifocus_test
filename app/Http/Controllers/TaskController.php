<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;


class TaskController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }


    // Display all tasks to do for team
    public function index()
    {
        return Task::all();
    }

    // Add new Task
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:50',
            'description'=>'required',
            'status' => 'required'
        ]);

        $task = $request->user()->tasks()->create($fields);

        return $task;
    }

    // Show a single task
    public function show(Task $task)
    {
        return $task;
    }

    // Update a single task
    // Can be done only by particular task creator
    public function update(Request $request, Task $task)
    {
        Gate::authorize('modify', $task);

        $fields = $request->validate([
            'title' => 'required|max:50',
            'description'=>'required',
            'status' => 'required'
        ]);

        $task-> update($fields);

        return $task;
    }

    // Delete a single task
    // Can be done only by particular task creator
    public function destroy(Task $task)
    {
        Gate::authorize('modify', $task);

        $task->delete();
        return ['message' => 'The Task was Deleted!'];
    }
}

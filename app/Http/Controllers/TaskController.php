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


    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('modify', $task);

        $task->delete();
        return ['message' => 'The Task was Deleted!'];
    }
}

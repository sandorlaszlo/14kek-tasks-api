<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Task::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // $task = new Task();
        // $task->title = $request->title;

        // $request->validate([
        //     'title' => ['required','string','max:50'],
        //     'description' => 'string',
        //     'published_at' => 'date',
        // ]);

        $user = auth()->user();
        $request->merge(['user_id' => $user->id]);
        $task = Task::create($request->all());

        $data = [
            'data' => $task,
            'message' => 'Task created successfully'
        ];
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // $task = Task::findOrFail($id);
        // $task = Task::find($id);
        // if (!$task) {
        //     return response()->json(['message' => 'Task not found'], 404);
        // }
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }

    public function published()
    {
        $tasks = Task::where('published_at', '<=', now())->get();
        return response()->json($tasks);
    }

    public function showPublished(Task $task)
    {
        if ($task->published_at > now()) {
            return response()->json(['message' => 'Task not published'], 404);
        }
        return response()->json($task);
    }
}

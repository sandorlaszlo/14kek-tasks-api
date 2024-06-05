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
        $user = auth()->user();
        $tasks = Task::where('user_id', $user->id)->get();
        return response()->json($tasks);
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

        if ($task->user_id != auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to make this request'], 403);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id != auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to make this request'], 403);
        }

        $task->update($request->all());
        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id != auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to make this request'], 403);
        }

        $task->delete();
        return response()->noContent();
    }

    public function published()
    {
        $user = auth()->user();
        $tasks = Task::where('published_at', '<=', now())
                        ->where('user_id', $user->id)
                        ->get();
        return response()->json($tasks);
    }

    public function showPublished(Task $task)
    {
        if ($task->user_id != auth()->user()->id) {
            return response()->json(['message' => 'You are not authorized to make this request'], 403);
        }
        
        if ($task->published_at > now()) {
            return response()->json(['message' => 'Task not published'], 404);
        }
        return response()->json($task);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        $task = Task::create($validated);
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}

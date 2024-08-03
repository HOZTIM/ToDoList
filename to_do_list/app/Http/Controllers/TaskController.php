<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
    }
    public function getAll()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }
    public function getById($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }
    public function create(Request $request, $id)
    {
        $task = $request;
        $task = Task::create($task);
        return response()->json($task);
    }
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update($request);
        return response()->json($task);
    }
    public function delete($id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json($task);
    }
}

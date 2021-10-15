<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TasksResource;
use App\Models\Task\Task;
use App\Services\Task\TaskGetter;
use App\Services\Task\TaskSaver;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = (new TaskGetter())
            ->orderBy($request->input('order_by'), $request->input('order_type'))
            ->paginate($request->input('per_page'));

        return new TasksResource($tasks);
    }

    public function store(Request $request)
    {
        $taskSaver = (new TaskSaver())
            ->fill($request->all())
            ->setUser()
            ->save();

        return new TaskResource($taskSaver->getInstance());
    }

    public function show($id)
    {
        return new TaskResource(Task::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $taskSaver = (new TaskSaver(Task::findOrFail($id)))
            ->fill($request->all())
            ->save();

        return new TaskResource($taskSaver->getInstance());
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return new TaskResource($task);
    }
}

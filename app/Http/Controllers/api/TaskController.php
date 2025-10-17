<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    public function show(int $id): TasksResource
    {
        $task = $this->findModel($id);
        return new TasksResource($task);
    }


    private function findModel(int $id): Task
    {
        $task = Task::query()->find($id);
        if (!$task) {
            abort(response()->json([
                'success' => false,
                'error' => 'Задача не найдена'
            ], 404));
        }
        return $task;
    }

    public function store(TaskStoreRequest $request): TasksResource
    {
        $task = Task::query()->create($request->validated());
        return new TasksResource($task);
    }

    public function index(): AnonymousResourceCollection
    {
        $tasks = Task::query()->paginate(20);
        return TasksResource::collection($tasks);
    }

    public function update(TaskUpdateRequest $request, int $id): TasksResource
    {
        $task = $this->findModel($id);

        $task->update($request->validated());
        return new TasksResource($task);
    }

    public function destroy(int $id): JsonResponse
    {
        $task = $this->findModel($id);
        return response()->json([
           'success' => $task->delete()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks.create');
    }

    public function store(TaskRequest $request, Task $task): RedirectResponse
    {
        $validated = $request->validated();
        $task->create($validated);
        return redirect(route('dashboard'));
    }



    public function edit(Task $task): View
    {
        $task = Task::query()->findOrFail($task->id);
        return view('tasks.edit', compact('task'));
    }


    public function update(TaskUpdateRequest $request, string $id): RedirectResponse
    {
        $validate = $request->validated();
        Task::query()
            ->where('id', $id)
            ->update($validate);

        return redirect(route('dashboard'));
    }


    public function destroy(string $id): RedirectResponse
    {
        $result = Task::query()->findOrFail($id);

        // Проверяем, что текущий пользователь владелец задачи или админ
        if ($result->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'You do not have permission to delete this task.');
        }
        $result->delete();
        return redirect(route('dashboard'));
    }
}

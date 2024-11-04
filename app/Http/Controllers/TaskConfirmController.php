<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TaskConfirmController extends Controller
{
    # здесь изменяем статус задачи на true 
    public function __invoke(Task $task): Redirector|RedirectResponse
    {
        $task->completed = 1;
        $task->save();
        return redirect(route('dashboard'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $searchTerm = trim($request->input('search'));
        $user = Auth::user();

        $tasks = Task::query()->when(!$user->isAdmin(), function ($query) use ($user) {
                // Применяем этот  фильтр по user_id, если пользователь не админ
                $query->where('user_id', $user->id);
        })
        ->when($request->filled('search'), function ($query) use ($searchTerm) {
                    $query->where('id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('title', 'like', '%' . $searchTerm . '%');
        })
        ->when($request->input('status') == 'completed', function ($query) {
            $query->where('completed', true);
        })
        ->when($request->input('status') == 'uncompleted', function ($query) {
                $query->where('completed', false);
        })
        ->when($request->input('status') == '', function ($query) {
            
        })
        ->orderByDesc('id')->paginate(6);
        return view('dashboard', compact('tasks'));
    }
}

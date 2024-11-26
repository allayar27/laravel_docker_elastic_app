<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Elasticsearch;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $searchTerm = trim($request->input('search'));
        $user = Auth::user();
        $tasksQuery = Task::query();

        if ($searchTerm) {
            $response = Elasticsearch::search([
                'index' => 'tasks',
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $searchTerm,
                            'fields' => ['title']
                        ]
                    ]
                ]
            ]);

            $taskIds = array_column($response['hits']['hits'], '_id');
            $tasksQuery->whereIn('id', $taskIds);
        }

        $tasks = $tasksQuery->when(!$user->isAdmin(), function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->when($request->input('status') == 'completed', function ($query) {
                $query->where('completed', true);
            })
            ->when($request->input('status') == 'uncompleted', function ($query) {
                $query->where('completed', false);
            })
            ->orderByDesc('id')->paginate(6);

        return view('dashboard', compact('tasks'));
    }

}

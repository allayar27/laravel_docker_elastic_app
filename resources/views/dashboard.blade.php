<x-app-layout>
    <x-slot name="header">
        <nav class="flex justify-center space-x-4">
            <a href="{{ route('dashboard') }}"
                class="font-medium px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">Home</a>
            {{-- <a href="{{ route('tasks.index') }}"
                class="font-medium px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">Tasks</a> --}}
            <a href="{{ route('users.index') }}"
                class="font-medium px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">Users</a>
            <a href="{{ route('users.index') }}"
                class="font-medium px-3 py-2 text-slate-700 rounded-lg hover:bg-slate-100 hover:text-slate-900">Reports</a>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-slot name="header">
                <nav class="navbar navbar-light bg-light">
                    <div class="container">
                        <form id="status-filter-form" action="{{ route('dashboard') }}" class="w-25" method="GET">
                            <select name="status" class="custom-select" onchange="filterByStatus()">
                                <option value="" selected>select all</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                    completed</option>
                                <option value="uncompleted" {{ request('status') == 'uncompleted' ? 'selected' : '' }}>
                                    uncompleted</option>
                            </select>
                        </form>
                        <a href="{{ route('tasks.create') }}">
                            <x-primary-button>{{ __('add task') }}</x-primary-button>
                        </a>
                    </div>
                </nav>
            </x-slot>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="flex justify-content-between">
                        <x-text-input name="search" type="text" class="mt-1 w-100" placeholder="search... " />
                        <x-primary-button class="ml-2 mt-1 w-15">{{ __('search') }}</x-primary-button>
                    </div>
                </form>

                <div class="card mt-3">
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" width="2%">ID</th>
                                        <th scope="col" width="7%">Title</th>
                                        <th scope="col" width="5%">Status</th>
                                        <th scope="col" width="1%" colspan="3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tasks as $task)
                                        <tr>
                                            <th scope="row">{{ $task->id }}</th>
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                @if ($task->completed == true)
                                                    <div class="badge bg-success">Completed</div>
                                                @else
                                                    <div class="badge bg-warning">Uncompleted</div>
                                                @endif
                                            </td>
                                            <td>
                                                <form id="confirm-task-form"
                                                    action="{{ route('tasks.confirm', $task->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" {{ $task->completed == true ? 'disabled' : '' }}>
                                                        <i class="bi bi-check-square"
                                                            style="font-size: 1rem; color: green;"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('tasks.edit', $task->id) }}" type="submit">
                                                    <i class="bi bi-pencil-square"
                                                        style="font-size: 1rem; color: blue;"></i>
                                                </a>
                                            </td>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <td>
                                                    <button type="submit">
                                                        <i class="bi bi-trash" style="font-size: 1rem; color: red;"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" style="text-align: center"
                                                class="px-6 py-4 whitespace-no-wrap text-sm leading">
                                                {{ __('No data not found') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $tasks->links() }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function filterByStatus() {
        const form = document.getElementById('status-filter-form');
        form.submit();
    }
</script>

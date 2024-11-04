<x-app-layout>
    <x-slot name="header">
        <nav class="flex justify-center space-x-4">
            <div class="container">
                <form action="{{ route('tasks.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div class="mb-3 space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="enter the title" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        <x-primary-button class="mt-1">{{ __('Save') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" width="2%">#</th>
                        <th scope="col" width="7%">title</th>
                        <th scope="col" width="7%">owner name</th>
                        <th scope="col" width="7%">date</th>
                        <th scope="col" width="7%">status</th>
                        <th scope="col" width="1%" colspan="3">actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->user->name }}</td>
                        <td>{{ $task->created_at }}</td>
                        <td>
                            @if($task->completed == true)
                                <div class="badge bg-success">Completed</div>
                            @else
                            <div class="badge bg-warning">Uncompleted</div>
                            @endif
                        </td>
                        <td>
                            <form id="confirm-task-form" action="{{ route('tasks.confirm', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">
                                <i class="bi bi-check-square" style="font-size: 1rem; color: green;"></i>
                            </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" type="submit">
                                <i class="bi bi-pencil-square" style="font-size: 1rem; color: blue;"></i>
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
                        <td colspan="7" style="text-align: center" class="px-6 py-4 whitespace-no-wrap text-sm leading">
                            {{ __('No data not found') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="card-footer d-flex justify-content-end">
                    {{ $tasks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>


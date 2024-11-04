<x-app-layout>
    <x-slot name="header">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/"><span class="navbar-brand mb-0 h1">Edit Task</span></a>
                <a href="{{ route('dashboard') }}"><button class="btn btn-danger">Cancel</button></a>
            </div>
        </nav>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('tasks.update', $task->id) }}" method="post" class="mt-3 p-3">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" value="{{ $task->title }}" class="mt-1 block w-full" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>
                <div class="mb-3">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea name="description" class="rounded mt-1 block w-full" id="description" rows="3">{{ $task->description }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
                <div>
                    <button class="btn btn-success">update</button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/"><span class="navbar-brand mb-0 h1">Create task</span></a>
                <a href="{{ route('dashboard') }}"><button class="btn btn-danger">Cancel</button></a>
            </div>
        </nav>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <form method="post" action="{{ route('tasks.store') }}" class="mt-6 space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                {{-- <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" /> --}}
                                <textarea name="description" class="mt-1 block w-full" id="description" rows="3"></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('tasks.store') }}" method="post" class="mt-3 p-3" style="width: 85%">
            @csrf
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="enter the title">
                @error('title') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                @error('description') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <button  class="btn btn-success">Create</button>
        </form>
    </div> --}}
</x-app-layout>

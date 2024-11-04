<x-app-layout>
    <x-slot name="header">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/"><span class="navbar-brand mb-0 h1">User About</span></a>
                <a href="{{ route('users.index') }}"><button class="btn btn-danger">Back</button></a>
            </div>
        </nav>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                            <div>
                               <strong>Name: {{ $user->name }}</strong> 
                            </div>
                            <div>
                               <strong>Email: {{ $user->email }}</strong> 
                            </div>
                            
                            <div class="py-2">
                            <strong >Roles: </strong>
                            <div class="grid grid-cols-4 gap-4">
                                @forelse ($user->roles as $role)
                                    <div class="col-span-4 sm:col-span-2 md:col-span-1">
                                        <label class="form-check-label">
                                            <strong>{{ $role->name }}</strong>
                                        </label>
                                    </div>
                                @empty
                                    ----
                                @endforelse
                            </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <a href="{{ route('users.edit', $user->id) }}">
                                    <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                </a>
                            </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


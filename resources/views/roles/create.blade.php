<x-app-layout>
    <x-slot name="header">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/"><span class="navbar-brand mb-0 h1">Create new Role</span></a>
                <a href="{{ route('roles.index') }}"><button class="btn btn-danger">Cancel</button></a>
            </div>
        </nav>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <form method="post" action="{{ route('roles.store') }}" class="mt-6 space-y-6">
                        @csrf
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="role name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="py-2">
                            <h3 class="inline-block text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight dark:text-slate-200 py-4 block sm:inline-block flex">Permissions</h3>
                            <table class="table table-striped">
                                    <thead>
                                        <th scope="col" width="1%"><input type="checkbox" name="all_permission"></th>
                                        <th scope="col" width="20%">Name</th>
                                        <th scope="col" width="1%">Guard</th> 
                                    </thead>
                                    @forelse($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox" 
                                                name="permission[{{ $permission->name }}]"
                                                value="{{ $permission->name }}"
                                                class='permission'>
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" style="text-align: center" class="px-6 py-4 whitespace-no-wrap text-sm leading">
                                                    {{ __('No data not found') }}
                                                </td>
                                            </tr>
                                    @endforelse
                                </table>
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
</x-app-layout>


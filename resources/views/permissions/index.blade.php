<x-app-layout>
    <x-slot name="header">
        <nav class="flex justify-center space-x-4">
            <div class="container">
                <form action="{{ route('permissions.store') }}" method="POST" class="mt-6 space-y-6">
                    @csrf
                    <div class="mb-3 space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="enter the name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
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
                        <th scope="col" width="5%">name</th>
                        <th scope="col" width="5%">guard name</th>
                        <th scope="col" width="1%" colspan="2">actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                            <a href="{{ route('permissions.edit', $permission->id) }}" type="submit">
                                <i class="bi bi-pencil-square" style="font-size: 1rem; color: blue;"></i>
                            </a>
                        </td>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="post">
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
        </div>
    </div>
</x-app-layout>


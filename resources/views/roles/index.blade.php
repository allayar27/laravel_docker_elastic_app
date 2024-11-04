<x-app-layout>
    <x-slot name="header">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/roles"><span class="navbar-brand mb-0 h1">Roles list</span></a>
                <a href="{{ route('roles.create') }}">
                    <x-primary-button>{{ __('create') }}</x-primary-button>
                </a>
            </div>
        </nav>
</x-slot>

<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" width="2%">#</th>
                        <th scope="col" width="7%">name</th>
                        <th scope="col" width="1%" colspan="3">actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($roles as $role)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('roles.show', $role->id) }}" type="submit">
                                <i class="bi bi-info-circle" style="font-size: 1rem; color: blue;"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}" type="submit">
                                <i class="bi bi-pencil-square" style="font-size: 1rem; color: blue;"></i>
                            </a>
                        </td>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
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


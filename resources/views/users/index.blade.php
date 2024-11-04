<x-app-layout>
    <x-slot name="header">


        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/"><span class="navbar-brand mb-0 h1">Users list</span></a>
                <a href="{{ route('users.create') }}">
                    <x-primary-button>{{ __('create') }}</x-primary-button>
                </a>
            </div>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="min-w-full border-b border-gray-200 shadow">
                <form method="GET" action="{{ route('users.index') }}">
                    <div class="py-2 flex">
                        <div class="overflow-hidden flex pl-4">
                            <input type="text" name="search" value="{{ old('search') }}"
                                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Search">
                            <button 
                                class='ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150'>
                                {{ __('Search') }}
                            </button>
                        </div>
                        

                    </div>
                </form>

                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" width="1%">#</th>
                            <th scope="col" width="8%">name</th>
                            <th scope="col" width="10%">email</th>
                            <th scope="col" width="7%">role</th>
                            <th scope="col" width="7%">registration date</th>
                            <th scope="col" width="1%" colspan="3">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <div class="badge bg-success">{{ $role->name }}</div>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user->id) }}" type="submit">
                                        <i class="bi bi-info-circle" style="font-size: 1rem; color: blue;"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" type="submit">
                                        <i class="bi bi-pencil-square" style="font-size: 1rem; color: blue;"></i>
                                    </a>
                                </td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="post">
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
                <div class="card-footer d-flex justify-content-end">
                    {{ $users->links() }}
                </div>
            </div>


        </div>
    </div>
</x-app-layout>



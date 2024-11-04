 <x-app-layout>
    <x-slot name="header">
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a href="/roles"><span class="navbar-brand mb-0 h1">Info Role</span></a>
                <a href="{{ route('roles.index') }}"><button class="btn btn-danger">Back</button></a>
            </div>
        </nav>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                            <div>
                               <strong>Role: {{ $role->name }}</strong> 
                            </div>
                            <div class="py-2">
                            <strong>Assigned permissions</strong>
                            <table class="table table-striped">
                                    <thead>
                                        <th scope="col" width="20%">Name</th>
                                        <th scope="col" width="1%">Guard</th> 
                                    </thead>
                                    @forelse($rolePermissions as $permission)
                                        <tr>
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
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

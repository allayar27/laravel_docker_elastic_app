<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Elasticsearch;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{

    public function index(Request $request): View
    {
        $query = trim($request->input('search'));
        $perPage = 6;
        $currentPage = $request->input('page', 1);
        
        if ($query) {
            $response = Elasticsearch::search([
                'index' => 'users',
                'body' => [
                    'query' => [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => [
                                'name',
                                'email'
                            ]
                        ]
                    ],
                    'from' => ($currentPage - 1) * $perPage,
                    'size' => $perPage
                ]
            ]);

            $userIds = array_column($response['hits']['hits'], '_id');
            $usersCollection = User::query()->findMany($userIds);

            $users = new LengthAwarePaginator(
                $usersCollection,
                $response['hits']['total']['value'],
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            $users = User::query()->latest()->paginate(6);
        }

        return view('users.index', compact('users'));
    }


    public function create(): View
    {
        $roles = Role::query()->latest()->get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        $validate = $request->validated();
        $validate['password'] = bcrypt($validate['password']);

        $user = User::create($validate);

        if (!empty($request->roles)) {
            $user->assignRole($request->roles);
        }

        return redirect(route('users.index'));
    }


    public function show(User $user)
    {
        $user->query()->findOrFail($user->id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->query()->findOrFail($user->id);
        $roles = Role::query()->latest()->get();
        $userHasRoles = $user->roles->pluck('name')->toArray();

        return view('users.edit', compact('user', 'roles', 'userHasRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->where('id', $user->id)->update($request->validated());
        $roles = $request->roles ?? [];
        $user->syncRoles($roles);

        return redirect(route('users.index'))->withSuccess(__('User updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->query()->find($user->id)->delete();
        return redirect(route('users.index'))->withSuccess(__('User deleted successfully.'));
    }
}

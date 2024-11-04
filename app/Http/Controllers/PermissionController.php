<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index', [
            'permissions' => $permissions
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);
        Permission::create($request->only('name'));

        return redirect()->route('permissions.index');
    }

 
    public function edit(Permission $permission)
    {
        $permission->query()->findOrFail($permission->id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

 
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id
        ]);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index');
    }


    public function destroy(Permission $permission)
    {
        $permission->query()->find($permission->id)->delete();
        return back();
    }
}

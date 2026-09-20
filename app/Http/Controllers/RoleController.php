<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    // 1. Get all roles
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'status' => true,
            'data'   => $roles
        ], 200);
    }

    // 2. Create new role
    public function store(Request $request)
    {
        $data = $request->validate([
            'role_name'   => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $role = Role::create($data);

        return response()->json([
            'status'  => true,
            'message' => 'Role created successfully!',
            'data'    => $role
        ], 201);
    }

    // 3. Get single role by ID
    public function show(Role $role)
    {
        return response()->json([
            'status' => true,
            'data'   => $role
        ], 200);
    }

    // 4. Update role
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'role_name'   => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'status'      => 'required|in:Active,Inactive',
        ]);

        $role->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Role updated successfully!',
            'data'    => $role
        ], 200);
    }

    // 5. Delete role
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Role deleted successfully!'
        ], 200);
    }
}

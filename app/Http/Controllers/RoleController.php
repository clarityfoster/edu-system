<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'status' => 'success',
            'roles' => $roles
        ]);
    }
    public function rolesForRegister() {
        $roles = Role::where('name', '!=', 'admin')->get();
        return response()->json([
            'roles' => $roles,
        ], 200);
    }
     public function create() {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }
        $role = new Role();
        $role->name = request('name');
        $role->save();
        return response()->json([
            'status' => 'success',
            'role' => $role
        ]);
    }
    public function read($id) {
        $role = Role::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'role' => $role
        ]);
    }

    public function edit($id) {
        $role = Role::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'role' => $role
        ]);
    }
    public function update($id) {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }
        $role = Role::findOrFail($id);
        $role->name = request()->name;
        $role->save();
        return response()->json([
            'status' => 'success',
            'role' => $role
        ]);
    }
    public function delete($id) {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json([
            'status' => 'successfully deleted!',
            'role' => $role
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::with('permission')->get();
            return response()->json([
                'status' => 'success',
                'roles' => $roles
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function rolesForRegister()
    {
        try {
            $roles = Role::where('name', '!=', 'admin')->get();
            return response()->json([
                'roles' => $roles,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function create()
    {
        try {
            $validator = validator(request()->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function read($id)
    {
        try {
            $role = Role::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'role' => $role
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function edit($id)
    {
        try {
            $role = Role::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'role' => $role
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function update($id)
    {
        try {
            $validator = validator(request()->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function delete($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json([
                'status' => 'successfully deleted!',
                'role' => $role
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
}

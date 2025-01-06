<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index() {
        $roles = Role::with('permission')->get();
        $permissions = Permission::with('role')->get();
        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }
    public function updatePermission() {
        $role = Role::findOrFail(request()->role_id);
        $permission_id = is_array(request()->permission_id) ? request()->permission_id : json_decode(request()->permission_id);
        $role->permission()->sync($permission_id);
        return response()->json([
            'success' => true,
            'role' => $role,
            'permission_id' => $permission_id
        ]);
    }
}

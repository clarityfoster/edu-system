<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function rolesForRegister() {
        $roles = Role::where('name', '!=', 'admin')->get();
        return response()->json([
            'roles' => $roles,
        ], 200);
    }
}

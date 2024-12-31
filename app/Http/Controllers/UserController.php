<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::with('role')->get();
        $roles = Role::all();
        return response()->json([
            'users' => $users,
            'roles' => $roles
        ]);
    }
}

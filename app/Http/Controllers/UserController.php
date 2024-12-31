<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Semester;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::with('role')->with('semester')->get();
        $roles = Role::all();
        $semesters = Semester::all();
        return response()->json([
            'users' => $users,
            'roles' => $roles,
            'semester' => $semesters,
        ]);
    }
    public function create() {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = request()->password;
        $user->save();
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function read($id) {
        $user = User::with('role')->findOrFail($id);
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function edit($id) {
        $user = User::with('role')->findOrFail($id);
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function update($id) {
        $user = User::with('role')->findOrFail($id);
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = request()->password;
        $user->role_id = request()->role_id;
        $user->save();
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'user' => $user
        ], 200);
    }
}

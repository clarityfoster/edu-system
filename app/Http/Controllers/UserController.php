<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function authUser() {
        $authUser = Auth::user()->load('role');
        return response()->json([
            'authUser' => $authUser
        ], 200);
    }
    public function index() {
        $users = User::with('role.permission')->with('semester.course')->get();
        $roles = Role::with('permission')->get();
        $permissions = Permission::with('role')->get();
        $semesters = Semester::with('course')->get();
        $courses = Course::with('semester')->get();
        return response()->json([
            'users' => $users,
            'roles' => $roles,
            'semester' => $semesters,
            'course' => $courses,
            'permission' => $permissions
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
    public function isApproved($id) {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();
        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }
    public function approvePending($id) {
        $user = User::findOrFail($id);
        $user->is_approved = false;
        $user->save();
        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }
    public function learnersList() {
        $learners = User::where('role_id', '3')->with('role')->with('semester')->get();
        return response()->json([
            'success' => true,
            'learners' => $learners
        ], 200);
    }
    public function instructorsList() {
        $instructors = User::where('role_id', '2')->with('role')->get();
        return response()->json([
            'success' => true,
            'instructors' => $instructors
        ], 200);
    }
}

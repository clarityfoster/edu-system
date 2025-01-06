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
            'phone' => 'required|digits_between:10,15',
            'semester_id' => 'required',
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
        $user->phone = request()->phone;
        $user->password = request()->password;
        $user->semester_id = request()->semester_id;
        $user->is_approved = 1;
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
    public function learnersCreate() {
        $validate = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits_between:10,15',
            'semester_id' => 'required',
            'password' => 'required|min:8',
        ]);
        if($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
            ], 422);
        }
        $learner = new User();
        $learner->name = request()->name;
        $learner->email = request()->email;
        $learner->phone = request()->phone;
        $learner->password = request()->password;
        $learner->semester_id = request()->semester_id;
        $learner->role_id = 3;
        $learner->is_approved = 1;
        $learner->save();
        return response()->json([
            'success' => true,
            'learner' => $learner,
        ]);
    }
    public function instructorsList() {
        $instructors = User::where('role_id', '2')->with('role')->get();
        return response()->json([
            'success' => true,
            'instructors' => $instructors
        ], 200);
    }
    public function instructorsCreate() {
        $validate = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|digits_between:10,15',
            'password' => 'required|min:8',
        ]);
        if($validate->fails()) {
            return response()->json([
                'errors' => $validate->errors(),
            ], 422);
        }
        $instructor = new User();
        $instructor->name = request()->name;
        $instructor->email = request()->email;
        $instructor->phone = request()->phone;
        $instructor->password = request()->password;
        $instructor->role_id = 2;
        $instructor->is_approved = 1;
        $instructor->save();
        return response()->json([
            'success' => true,
            'instructor' => $instructor,
        ]);
    }
}

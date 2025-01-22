<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function authUser() {
        try {
            $authUser = Auth::user()->load('role');
            return response()->json([
                'authUser' => $authUser
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function index() {
        try {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function create() {
        try {
            $validator = validator(request()->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => ['required', 'regex:/^\+?[0-9]{1,4}?[-.\s]?[0-9]{1,3}[-.\s]?[0-9]{4,10}$/'],
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
            $user->course_id = request()->course_id;
            $user->is_approved = 1;
            $user->save();
            return response()->json([
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function read($id) {
        try {
            $user = User::with('role')->findOrFail($id);
            return response()->json([
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function edit($id) {
        try {
            $user = User::with('role')->findOrFail($id);
            return response()->json([
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function update($id) {
        try {
            $validate = Validator(request()->all(), [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email',
                'phone' => 'nullable',
                'role_id' => 'nullable',
                'semester_id' => 'nullable',
            ]);
            if($validate->fails()) {
                return response()->json([
                    'errors' => $validate->errors(),
                ], 422);
            }
            $user = User::with('role')->findOrFail($id);
            if(request()->has('name')) {
                $user->name = request()->name;
            }
            if(request()->has('email')) {
                $user->email = request()->email;
            }
            if(request()->has('role_id')) {
                $user->role_id = request()->role_id;
            }
            if(request()->has('phone')) {
                $user->phone = request()->phone;
            }
            if(request()->has('semester_id')) {
                $user->semester_id = request()->semester_id;
            }
            $user->save();
            return response()->json([
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function delete($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function isApproved($id) {
        try {
            $user = User::findOrFail($id);
            $user->is_approved = true;
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function approvePending($id) {
        try {
            $user = User::findOrFail($id);
            $user->is_approved = false;
            $user->save();
            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function learnersList() {
        try {
            $learners = User::where('role_id', 3)->where('is_approved', 1)->with('role')->with('semester')->get();
            return response()->json([
                'success' => true,
                'learners' => $learners
            ], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function learnersCreate() {
        try {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function instructorsList() {
        try {
            $instructors = User::where('role_id', 2)->where('is_approved', 1)->with('role')->get();
            return response()->json([
                'success' => true,
                'instructors' => $instructors
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
    public function instructorsCreate() {
        try {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }
}

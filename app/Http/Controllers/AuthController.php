<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register() {
        $validator = Validator(request()->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'required|string',
            'role_id' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors(),
            ], 422);
        };
        $role = Role::findOrFail(request()->role_id);
        if(!$role || $role->name === "admin") {
            return response()->json([
                'success' => false,
                'error' => 'You are not allowed to register as an admin.',
            ]);
        }
        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->phone = request()->phone;
        $user->password = request()->password;
        $user->role_id = $roles->id;
        $user->save();
        $user->makeVisible('password');
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function login() {
        $validator = Validator(request()->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors(),
            ], 422);
        };
        if(!Auth::attempt(request()->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }
        $user = Auth::user();
        if($user-> is_approved === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please wait for a moment the admin\'s approval.',
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}

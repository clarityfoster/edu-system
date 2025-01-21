<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    public function register() {
        try {
            $validator = Validator(request()->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required',
                'role_id' => 'required',
                'semester_id' => 'nullable',
            ]);
            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->errors(),
                ], 422);
            };

            $user = new User();
            $user->name = request()->name;
            $user->email = request()->email;
            $user->password = request()->password;
            $user->role_id = request()->role_id;
            $user->semester_id = request()->semester_id;
            $user->save();
            $user->makeVisible('password');
            return response()->json([
                'user' => $user
            ], 200);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }
    public function login() {
        try {

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
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success'=> false,
                'error'=> $e->getMessage(),
            ]);
        }
    }
    public function logout() {
        try {

        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
        ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status'=> 'error',
                'error'=> $e->getMessage(),
            ]);
        }
    }
}

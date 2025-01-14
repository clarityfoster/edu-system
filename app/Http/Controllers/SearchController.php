<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(){
        try {
            $query = request()->input('query');
            if ($query) {
                $users = User::with('role.permission', 'semester.course')
                    ->where('name', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%")
                    ->orWhere('phone', 'like', "%$query%")
                    ->orWhereHas('role', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('semester', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->orWhereHas('semester.course', function ($q) use ($query) {
                        $q->where('name', 'like', "%$query%");
                    })
                    ->get();
                $roles = Role::with('permission')
                    ->where('name', 'like', "%$query%")
                    ->get();
                $semesters = Semester::with('course')
                    ->where('name', 'like', "%$query%")
                    ->get();
                $courses = Course::with('semester')
                    ->where('name', 'like', "%$query%")
                    ->get();
                return response()->json([
                    'status' => 'success',
                    'users' => $users->isEmpty() ? 'No users found for this query' : $users,
                    'roles' => $roles->isEmpty() ? 'No roles found for this query' : $roles,
                    'semesters' => $semesters->isEmpty() ? 'No semesters found for this query' : $semesters,
                    'courses' => $courses->isEmpty() ? 'No courses found for this query' : $courses,
                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Query parameter is required.',
            ], 400);

        } catch(ModelNotFoundException $e) {
            return response()->json([
                'status' => 'Error: ' . $e->getMessage() ,
            ]);
        }
    }
}

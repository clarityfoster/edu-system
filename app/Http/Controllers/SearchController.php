<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Permission;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search() {
        $query = request()->input('query');
        if($query) {
            $users = User::with('role.permission')->with('semester.course')
                            ->where('name', 'like', "%$query%")
                            ->orwhere('email', 'like', "%$query%")
                            ->orwhere('phone', 'like', "%$query%")
                            ->get();
            $roles = Role::with('permission')
                            ->where('name', 'like', "%$query%")
                            ->get();
            $permissions = Permission::with('role')
                                    ->where('name', 'like', "%$query%")
                                    ->get();
            $semesters = Semester::with('course')
                                    ->where('name', 'like', "%$query%")
                                    ->get();
            $courses = Course::with('semester')
                                ->where('name', 'like', "%$query%")
                                ->get();
        } else {
            return;
        }
        return response()->json([
            'status' => 'success',
            'users' => $users->isEmpty() ? 'No users found for this query' : $users,
            'roles' => $roles->isEmpty() ? 'No roles found for this query' : $roles,
            'permissions' => $permissions->isEmpty() ? 'No permissions found for this query' : $permissions,
            'semesters' => $semesters->isEmpty() ? 'No semesters found for this query' : $semesters,
            'courses' => $courses->isEmpty() ? 'No courses found for this query' : $courses,
        ], 200);
    }
}

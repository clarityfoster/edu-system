<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Permission;
use App\Models\UserPermission;
use Illuminate\Database\Seeder;
use App\Models\CoursePermission;
use App\Models\SemesterPermission;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory(20)->create();
        \App\Models\User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
            'role_id' => 1,
            'semester_id' => null,
            'is_approved' => 1,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'role_id' => 2,
            'semester_id' => null,
            'is_approved' => 1,
        ]);
        $roles = ['Admin', 'Instructor', 'Learner'];
        foreach ($roles as $role) {
            \App\Models\Role::create([
                'name' => $role,
            ]);
        }
        $semesters = [
            ['name' => 'First Semester', 'start_date' => '2025-01-01', 'end_date' => '2025-06-30'],
            ['name' => 'Second Semester', 'start_date' => '2025-07-01', 'end_date' => '2025-12-31'],
            ['name' => 'Third Semester', 'start_date' => '2026-01-01', 'end_date' => '2026-06-30'],
            ['name' => 'Fourth Semester', 'start_date' => '2026-07-01', 'end_date' => '2026-12-31'],
        ];
        foreach ($semesters as $semester) {
            Semester::create($semester);
        }
        $courses = [
            ['name' => 'Introduction to Programming'],
            ['name' => 'Introduction to Web Development'],
            ['name' => 'Object-Oriented Programming in Java'],
            ['name' => 'Binary Tree Algorithms'],
        ];
        foreach($courses as $course) {
            Course::create($course);
        }
        $semesterCourseMapping = [
            'First Semester' => ['Introduction to Programming'],
            'Second Semester' => ['Introduction to Web Development'],
            'Third Semester' => ['Object-Oriented Programming in Java'],
            'Fourth Semester' => ['Binary Tree Algorithms'],
        ];
        foreach($semesterCourseMapping as $semesterName => $courseNames) {
            $semesterName = Semester::where('name', $semesterName)->first();
            foreach($courseNames as $courseName) {
                $course = Course::where('name', $courseName)->first();
                DB::table('semester_courses')->insert([
                    'semester_id' => $semesterName->id,
                    'course_id' => $course->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $permissions = [
            'user' => ['create-user', 'view-user', 'update-user', 'delete-user'],
            'role' => ['create-role', 'view-role', 'update-role', 'delete-role'],
            'semester' => ['create-semester', 'view-semester', 'update-semester', 'delete-semester'],
            'course' => ['create-course', 'view-course', 'update-course', 'delete-course'],
        ];
        foreach($permissions as $category => $categoryPermissions) {
            foreach($categoryPermissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'category' => $category,
                ]);
            }
        }
        $adminRole = Role::where('name', 'Admin')->first();
        $learnerRole = Role::where('name', 'Learner')->first();
        if($adminRole) {
            $adminRole->permission()->attach(Permission::all());
        }

        $instructorRole = Role::where('name', 'Instructor')->first();
        $instructorPermissions = Permission::where('category', 'course')
                                            ->orWhere('category', 'semester')
                                            ->orWhereIn('name', [
                                                'view-user', 'update-user', 'create-user', 'view-role'
                                            ])
                                            ->get();
        if($instructorRole) {
            $instructorRole->permission()->attach($instructorPermissions->pluck('id'));
        }
        $learnerRole = Role::where('name', 'Learner')->first();
        $learnerPermissions = Permission::whereIn('name', [
                                                'view-user', 'update-user', 'delete-user',
                                                'view-role', 'view-semester', 'view-course'
                                            ])
                                            ->get();
        if($learnerRole) {
            $learnerRole->permission()->attach($learnerPermissions->pluck('id'));
        }
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();
        \App\Models\User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
            'role_id' => 1,
            'semester_id' => null,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'role_id' => 2,
            'semester_id' => null,
        ]);
        $roles = ['Admin', 'Instructor', 'Learner'];
        foreach ($roles as $role) {
            \App\Models\Role::factory()->create([
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
            \App\Models\Semester::factory()->create($semester);
        }

        $courses = [
            'Introduction to Programming',
            'Introduction to Web Development',
            'Object-Oriented Programming in Java',
            'Binary Tree Algorithms',
        ];
        foreach($courses as $course) {
            Course::factory()->create([
                'name' => $course,
            ]);
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

        $permissions = ['view', 'user-create', 'user-update', 'user-delete'];
        foreach ($permissions as $permission) {
            \App\Models\Permission::factory()->create([
                'name' => $permission,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::with('semester')->get();
        return response()->json([
            'status' => 'success',
            'courses' => $courses,
        ]);
    }
    public function create() {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'semester_id' => 'nullable|integer'
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }
        $course = new Course();
        $course->name = request('name');
        $course->save();
        return response()->json([
            'status' => 'success',
            'course' => $course
        ]);
    }
    public function read($id) {
        $course = Course::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'course' => $course
        ]);
    }
    public function edit($id) {
        $course = Course::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'course' => $course
        ]);
    }
    public function update($id) {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }
        $course = Course::findOrFail($id);
        $course->name = request()->name;
        $course->save();
        return response()->json([
            'status' => 'success',
            'course' => $course
        ]);
    }
    public function delete($id) {
        $course = Course::findOrFail($id);
        $course->delete();
        return response()->json([
            'status' => 'successfully deleted!',
            'course' => $course
        ]);
    }
}

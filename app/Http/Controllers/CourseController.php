<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        try {
            $courses = Course::with('semester')->get();
            return response()->json([
                'status' => 'success',
                'courses' => $courses,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->getMessage(),
            ]);
        }
    }
    public function create()
    {
        try {
            $validator = validator(request()->all(), [
                'name' => 'required|string|unique|max:255',
                'semester_id' => 'nullable|integer',
            ]);
            if ($validator->fails()) {
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
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->getMessage(),
            ]);
        }
    }
    public function read($id)
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'course' => $course
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->getMessage(),
            ]);
        }
    }
    public function edit($id)
    {
        try {
            $course = Course::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'course' => $course
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->getMessage(),
            ]);
        }
    }
    public function update($id)
    {
        try {
            $validator = validator(request()->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
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

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function delete($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json([
                'status' => 'successfully deleted!',
                'course' => $course
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
            ]);
        }
    }
}

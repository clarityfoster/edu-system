<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SemesterController extends Controller
{
    public function index() {
        try {
            $semesters = Semester::with('course')->get();
            return response()->json([
                'status' => 'success',
                'semesters' => $semesters
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
    public function create() {
        try {
            $validator = validator(request()->all(), [
                'name' => 'required|string|max:255|unique:semesters',
                'course_id' => 'required|array',
                'course_id.*' => 'required|integer|exists:courses,id',
                'start_date' => 'required|date|before:end_date',
                'end_date' => 'required|date|after:start_date',
            ],[
                'start_date.before' => 'The start date must be before the end date.',
                'end_date.after' => 'The end date must be after the start date.',
            ],[
                'start_date.before' => 'The start date must be before the end date.',
                'end_date.after' => 'The end date must be after the start date.',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ]);
            }
            $semester = new Semester();
            $semester->name = request('name');
            $semester->start_date = request('start_date');
            $semester->end_date = request('end_date');
            $semester->save();
            $semester->course()->attach(request('course_id'));
            return response()->json([
                'status' => 'success',
                'semester' => $semester->load('course'),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
    public function read($id) {
        try {
            $semester = Semester::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'semester' => $semester
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
    public function edit($id) {
        try {
            $semester = Semester::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'semester' => $semester
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
   public function update($id) {
        try {
            $validator = validator(request()->all(), [
                'name' => 'nullable|string|max:255',
                'course_id' => 'nullable|array',
                'course_id.*' => 'nullable|integer|exists:courses,id',
                'start_date' => 'required|date|before:end_date',
                'end_date' => 'required|date|after:start_date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors(),
                ]);
            }

            $semester = Semester::findOrFail($id);
            $semester->name = request()->name;
            $semester->start_date = request()->start_date;
            $semester->end_date = request()->end_date;
            $semester->course()->sync(request('course_id'));
            $semester->save();

            return response()->json([
                'status' => 'success',
                'semester' => $semester->load('course'),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
    public function delete($id) {
        $semester = Semester::findOrFail($id);
        $semester->delete();
        return response()->json([
            'status' => 'successfully deleted!',
            'semester' => $semester
        ]);
    }
    public function getOngoingSemester() {
        try {
            $ongoingsemesters = Semester::where('start_date', '<=', now())
                                ->where('end_date', '>=', now())
                                ->with('course')
                                ->with('user')
                                ->withCount('user')
                                ->get();
            return response()->json([
                'status' => 'success',
                'ongoingsemesters' => $ongoingsemesters
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
    public function completedSemester() {
        try {
            $completedSemesters = Semester::where('end_date', '<', now())
                                ->with('course')
                                ->with('user')
                                ->withCount('user')
                                ->get();
            return response()->json([
                'status' => 'success',
                'completedSemesters' => $completedSemesters
            ]);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Semester not found',
            ]);
        }
    }
}

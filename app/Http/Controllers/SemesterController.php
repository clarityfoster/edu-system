<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index() {
        $semesters = Semester::with('course')->get();
        return response()->json([
            'status' => 'success',
            'semesters' => $semesters
        ]);
    }
    public function create() {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255|unique:semesters',
            'course_id' => 'required|array',
            'course_id.*' => 'required|integer|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
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
    }
    public function read($id) {
        $semester = Semester::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'semester' => $semester
        ]);
    }
    public function edit($id) {
        $semester = Semester::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'semester' => $semester
        ]);
    }
    public function update($id) {
        $validator = validator(request()->all(), [
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ]);
        }
        $semester = Semester::findOrFail($id);
        $semester->name = request()->name;
        $semester->start_date = request()->start_date;
        $semester->end_date = request()->end_date;
        $semester->save();
        return response()->json([
            'status' => 'success',
            'semester' => $semester
        ]);
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
        $semesters = Semester::where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->with('course')
                            ->with('user')
                            ->withCount('user')
                            ->get();
        return response()->json([
            'status' => 'success',
            'semesters' => $semesters
        ]);
    }
    public function completedSemester() {
        $semesters = Semester::where('start_date', '>=', now())
                            ->where('end_date', '<=', now())
                            ->with('course')
                            ->with('user')
                            ->withCount('user')
                            ->get();
        return response()->json([
            'status' => 'success',
            'semesters' => $semesters
        ]);
    }
}

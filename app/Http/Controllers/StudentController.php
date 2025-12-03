<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('classroom')->latest()->get();
        $classrooms = Classroom::all();
        return view('students.index', compact('students', 'classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|unique:students,nisn',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'email' => 'required|email|unique:students,email',
            'classroom_id' => 'required|exists:classrooms,id',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Student::create([
            'classroom_id' => $request->classroom_id,
            'nisn' => $request->nisn,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return response()->json(['success' => 'Student Successfully added!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nisn' => 'required|unique:students,nisn,' . $id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'email' => 'required|email|unique:students,email,' . $id,
            'classroom_id' => 'required|exists:classrooms,id',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $student->update([
            'classroom_id' => $request->classroom_id,
            'nisn' => $request->nisn,
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        return response()->json(['success' => 'Data siswa berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return response()->json(['success' => 'Successfully deleted']);
    }
}

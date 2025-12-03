<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('classroom')->latest()->get();
        $classrooms = Classroom::all();
        return view('teachers.index', compact('teachers', 'classrooms'));
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
            'nip' => 'required|unique:teachers,nip',
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'gender' => 'required',
            'expertise' => 'required',
            'address' => 'nullable|string',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Teacher::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'expertise' => $request->expertise,
            'gender' => $request->gender,
            'address' => $request->address,
            'classroom_id' => $request->classroom_id,
        ]);

        return response()->json(['success' => 'Guru berhasil ditambahkan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return response()->json($teacher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:teachers,nip,' . $id,
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'gender' => 'required',
            'expertise' => 'required',
            'address' => 'nullable|string',
            'classroom_id' => 'nullable|exists:classrooms,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $teacher->update([
            'nip' => $request->nip,
            'name' => $request->name,
            'email' => $request->email,
            'expertise' => $request->expertise,
            'gender' => $request->gender,
            'address' => $request->address,
            'classroom_id' => $request->classroom_id,
        ]);

        return response()->json(['success' => 'Guru berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();
        return response()->json(['success' => 'Guru dihapus!']);
    }
}

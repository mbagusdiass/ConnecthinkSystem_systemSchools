<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::latest()->paginate(10);

        return view('classrooms.index', compact('classrooms'));
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
            'name' => 'required|string|max:50|unique:classrooms,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Classroom::create(['name' => $request->name]);

        return response()->json(['success' => 'Classrooms Success Created!!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       $classroom = Classroom::findOrFail($id);
       return response()->json($classroom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|unique:classrooms,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $classroom->update(['name' => $request->name]);

        return response()->json(['success' => 'Classrooms succesfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        if ($classroom->students()->count() > 0) {
            return response()->json(['error' => 'Failed! This class still contain student.'], 400);
        }
        $classroom->delete();
        return response()->json(['success' => 'Succesfully deleted!']);
    }
}

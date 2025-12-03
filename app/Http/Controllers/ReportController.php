<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('reports.index');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $type = $request->query('type');
        $html = '';
        if ($type == 'students_by_class') {
            $classrooms = Classroom::with('students')->get();
            $html = view('reports.partials.students_table', compact('classrooms'))->render();

        } elseif ($type == 'teachers_by_class') {
            $classrooms = Classroom::with('teachers')->get();
            $html = view('reports.partials.teachers_table', compact('classrooms'))->render();

        } elseif ($type == 'complete_list') {
            $classrooms = Classroom::with(['students', 'teachers'])->get();
            $html = view('reports.partials.complete_table', compact('classrooms'))->render();
        }

        return response()->json(['html' => $html]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

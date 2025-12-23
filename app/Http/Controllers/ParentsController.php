<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents  = Parents::all();
        return view('parents.index', compact('parents'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Parents::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return response()->json(['success' => 'Parent Successfully added!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Parents $parents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $parent = Parents::findOrFail($id);
        return response()->json($parent);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $parent = Parents::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,'. $id,
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $parent->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return response()->json(['success' => 'Data wali murid berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Parents::findOrFail($id)->delete();
        return response()->json(['success' => 'Successfully deleted']);
    }
}

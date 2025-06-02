<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;

class CoachController extends Controller
{
    public function index()
    {
        return Coach::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_name' => 'required|string|max:50',
            'coach_name' => 'required|string|max:20',
            'total_seats' => 'required|integer'
        ]);
        return Coach::create($data);
    }

    public function show($id)
    {
        return Coach::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'class_name' => 'string|max:50',
            'coach_name' => 'string|max:20',
            'total_seats' => 'integer'
        ]);
        $coach = Coach::findOrFail($id);
        $coach->update($data);
        return $coach;
    }

    public function destroy($id)
    {
        Coach::findOrFail($id)->delete();
        return response()->json(['message' => 'Coach deleted']);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\WorkoutProgram;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WorkoutController extends Controller
{
    public function read()
    {
        $programs = WorkoutProgram::all();
        return view('workouts/programs', ['programs' => $programs]);
    }
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "trainer_id"=>'required',
            "name"=>'required',
            "description"=>'required',
            "duration" => 'required'
        ]);
        WorkoutProgram::create($incomeFields);
        return redirect('/programs');
    }   
    public function showUpdateForm($id)
    {
        $program = WorkoutProgram::findOrFail($id);
        return view('workouts/program-edit', ['program' => $program]);
    }   
    public function update($id, Request $request)
    {
        $program = WorkoutProgram::findOrFail($id);
        $incomeFields = $request->validate([
            "trainer_id"=>'required',
            "name"=>'required',
            "description"=>'required',
            "duration" => 'required'
        ]);
        $program->update($incomeFields);
        return redirect('/programs');
    }   

    public function delete($id)
    {
        $program = WorkoutProgram::findOrFail($id);
        $program->delete();
        return redirect('/programs');
    } 
}

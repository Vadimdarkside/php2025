<?php

namespace App\Http\Controllers;

use App\Models\WorkoutProgram;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WorkoutController extends Controller
{
    public function read(Request $request)
    {
        if($request->get('filter'))
        {
            $name = $request->get('name');
            $trainer_id = $request->get('trainer_id');
            $description = $request->get('description');
            $duration = $request->get('duration');
            $programs = WorkoutProgram::query();
            if ($name) {
                $programs->where('name', 'like', '%' . $name . '%');
            }
            if ($trainer_id) {
                $programs->where('trainer_id', $trainer_id );
            }
            if ($description) {
                $programs->where('description', 'like', '%' . $description . '%');
            }
            if ($duration) {
                $programs->where('duration', $duration );
            }
            $programs = $programs->get();

            return view('workouts/programs', ['programs' => $programs]);
        }
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

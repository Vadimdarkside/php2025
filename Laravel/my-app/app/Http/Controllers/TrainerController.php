<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrainerController extends Controller
{
    public function read()
    {
        $trainers = Trainer::all();
        return view('trainers/trainers', ['trainers' => $trainers]);
    }
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "first_name"=>'required',
            "last_name"=>'required',
            "email"=>'required',
            "specialty" => 'required'
        ]);
        Trainer::create($incomeFields);
        return redirect('/trainers');
    }   
    public function showUpdateForm($id)
    {
        $trainer = Trainer::findOrFail($id);
        return view('trainers/trainer-edit', ['trainer' => $trainer]);
    }   
    public function update($id, Request $request)
    {
        $trainer = Trainer::findOrFail($id);
        $incomeFields = $request->validate([
            "first_name"=>'required',
            "last_name"=>'required',
            "email"=>'required',
            "specialty" => 'required'
        ]);
        $trainer->update($incomeFields);
        return redirect('/trainers');
    }   

    public function delete($id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();
        return redirect('/trainers');
    }   
}

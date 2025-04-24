<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TrainerController extends Controller
{
    public function read(Request $request)
    {
        if($request->get('filter'))
        {
            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $email = $request->get('email');
            $specialty = $request->get('specialty');
            $trainers = Trainer::query();
            if ($first_name) {
                $trainers->where('first_name', 'like', '%' . $first_name . '%');
            }
            if ($last_name) {
                $trainers->where('last_name', 'like', '%' . $last_name . '%');
            }
            if ($email) {
                $trainers->where('email', 'like', '%' . $email . '%');
            }
            if ($specialty) {
                $trainers->where('specialty', 'like', '%' . $specialty . '%');
            }
            
            $trainers = $trainers->get();

            return view('trainers/trainers', ['trainers' => $trainers]);
        }
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

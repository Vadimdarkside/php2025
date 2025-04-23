<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController
{
    public function read()
    {
        $enrolls = Enrollment::all();
        return view('enrollments/enroll', ['enrolls' => $enrolls]);
    }
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "client_id"=>'required',
            "program_id"=>'required',
            "start_date"=>'required',
            "status" => 'required'
        ]);
        Enrollment::create($incomeFields);
        return redirect('/enrolls');
    }   
    public function showUpdateForm($id)
    {
        $enroll = Enrollment::findOrFail($id);
        return view('enrollments/enroll-edit', ['enroll' => $enroll]);
    }   
    public function update($id, Request $request)
    {
        $enroll = Enrollment::findOrFail($id);
        $incomeFields = $request->validate([
            "client_id"=>'required',
            "program_id"=>'required',
            "start_date"=>'required',
            "status" => 'required'
        ]);
        $enroll->update($incomeFields);
        return redirect('/enrolls');
    }   

    public function delete($id)
    {
        $enroll = Enrollment::findOrFail($id);
        $enroll->delete();
        return redirect('/enrolls');
    } 
}

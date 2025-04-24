<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController
{
    public function read(Request $request)
    {
        if($request->get('filter'))
        {
            $client_id = $request->get('client_id');
            $program_id = $request->get('program_id');
            $start_date = $request->get('start_date');
            $status = $request->get('status');
            $enrolls = Enrollment::query();
            if ($client_id) {
                $enrolls->where('client_id', $client_id);
            }
            if ($program_id) {
                $enrolls->where('program_id', $program_id );
            }
            if ($start_date) {
                $enrolls->whereDate('start_date', $start_date);
            }
            if ($status) {
                $enrolls->where('status', $status );
            }
            $enrolls = $enrolls->get(); 

            return view('enrollments/enroll', ['enrolls' => $enrolls]);
        }
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

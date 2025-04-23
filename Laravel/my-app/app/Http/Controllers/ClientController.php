<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function read()
    {
        $clients = Client::all();
        return view('clients/clients', ['clients' => $clients]);
    }
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "first_name"=>'required',
            "last_name"=>'required',
            "email"=>'required',
            "registration_date" => 'required'
        ]);
        Client::create($incomeFields);
        return redirect('/clients');
    }   
    public function showUpdateForm($id)
    {
        $client = Client::findOrFail($id);
        return view('clients/client-edit', ['client' => $client]);
    }   
    public function update($id, Request $request)
    {
        $client = Client::findOrFail($id);
        $incomeFields = $request->validate([
            "first_name"=>'required',
            "last_name"=>'required',
            "email"=>'required',
        ]);
        $client->update($incomeFields);
        return redirect('/clients');
    }   

    public function delete($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect('/clients');
    }   
}

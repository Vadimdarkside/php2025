<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientController extends Controller
{
    public function read(Request $request)
    {
        $clientsQuery = Client::query();

        if ($request->get('filter')) {
            $first_name = $request->get('first_name');
            $last_name = $request->get('last_name');
            $email = $request->get('email');
            $phone = $request->get('phone');
            $registration_date = $request->get('registration_date');

            if ($first_name) {
                $clientsQuery->where('first_name', 'like', '%' . $first_name . '%');
            }
            if ($last_name) {
                $clientsQuery->where('last_name', 'like', '%' . $last_name . '%');
            }
            if ($email) {
                $clientsQuery->where('email', 'like', '%' . $email . '%');
            }
            if ($phone) {
                $clientsQuery->where('phone', 'like', '%' . $phone . '%');
            }
            if ($registration_date) {
                $clientsQuery->whereYear('registration_date', $registration_date);
            }
        }

        $perPage = $request->get('per_page', 5);
        $clients = $clientsQuery->paginate($perPage);
        return view('clients/clients', ['clients' => $clients]);
    }
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "first_name"=>'required',
            "last_name"=>'required',
            "email"=>'required',
            "phone"=>'required',
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
            "phone"=>'required'
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

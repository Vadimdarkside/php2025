<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin']);
    }

    public function index(): JsonResponse
    {
        return response()->json(Client::all(), 200);
    }

    public function show($id): JsonResponse
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:clients',
            'password'   => 'required|string|min:6',
            'phone'      => 'nullable|string',
            'roles'      => 'required|string'
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['registration_date'] = now();

        $client = Client::create($validated);

        return response()->json($client, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name'  => 'sometimes|required|string|max:255',
            'email'      => 'sometimes|required|email|unique:clients,email,' . $id,
            'password'   => 'sometimes|required|string|min:6',
            'phone'      => 'nullable|string',
            'roles'      => 'sometimes|required|string'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $client->update($validated);

        return response()->json($client, 200);
    }

    public function destroy($id): JsonResponse
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted successfully'], 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Trainer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api'); 
        $this->middleware(function ($request, $next) {
            if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return $next($request);
        });
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request)
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

        return response()->json(['trainers' => $trainers]);
    }

    /**
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $incomeFields = $request->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required',
            "specialty" => 'required',
        ]);

        $trainer = Trainer::create($incomeFields);

        return response()->json(['message' => 'Trainer created successfully', 'trainer' => $trainer], 201);
    }

    /**
     *
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $trainer = Trainer::findOrFail($id);

        $incomeFields = $request->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required',
            "specialty" => 'required',
        ]);

        $trainer->update($incomeFields);

        return response()->json(['message' => 'Trainer updated successfully', 'trainer' => $trainer]);
    }

    /**
     * 
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $trainer = Trainer::findOrFail($id);
        $trainer->delete();

        return response()->json(['message' => 'Trainer deleted successfully']);
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\WorkoutProgram;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WorkoutController extends Controller
{
    public function __construct()
    {
        // Тільки користувачам з роллю адмін або менеджер дозволено виконувати такі дії
        $this->middleware('checkUserRole')->only(['create', 'update', 'delete']);
    }

    /**
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function read(Request $request)
    {
        $programs = WorkoutProgram::query();

        if ($request->get('filter')) {
            $name = $request->get('name');
            $trainer_id = $request->get('trainer_id');
            $description = $request->get('description');
            $duration = $request->get('duration');

            if ($name) {
                $programs->where('name', 'like', '%' . $name . '%');
            }
            if ($trainer_id) {
                $programs->where('trainer_id', $trainer_id);
            }
            if ($description) {
                $programs->where('description', 'like', '%' . $description . '%');
            }
            if ($duration) {
                $programs->where('duration', $duration);
            }
        }

        $programs = $programs->get();

        return response()->json([
            'status' => 'success',
            'data' => $programs
        ]);
    }

    /**
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trainer_id' => 'required|exists:trainers,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'duration' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        $program = WorkoutProgram::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $program
        ], 201);
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
        $program = WorkoutProgram::find($id);

        if (!$program) {
            return response()->json([
                'status' => 'error',
                'message' => 'Program not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'trainer_id' => 'required|exists:trainers,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'duration' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

        $program->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $program
        ]);
    }

    /**
     * 
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $program = WorkoutProgram::find($id);

        if (!$program) {
            return response()->json([
                'status' => 'error',
                'message' => 'Program not found'
            ], 404);
        }

        $program->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Program deleted successfully'
        ]);
    }
}

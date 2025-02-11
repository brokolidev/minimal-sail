<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{

    /**
     * Creating a new student
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name'  => 'required|string|max:255',
            'age'   => 'required|integer',
            'grade' => 'required|integer',
            'gpa'   => 'required|numeric|min:0|max:4',
        ]);

        // Check if a student with the same name already exists
        $existingStudent = Student::where('name', $request->name)->first();
        if ($existingStudent) {
            throw ValidationException::withMessages([
                'name' => 'A student aleady exists.'
            ])->status(Response::HTTP_CONFLICT);
        }

            // Create a new student
        $student = Student::create($validatedData);

        // Return a response
        return response()->json([
            'message' => 'Student created successfully',
            'timestamp' => date('Y-m-d h:i:s'),
            'data' => $student
        ], 201);
    }
}

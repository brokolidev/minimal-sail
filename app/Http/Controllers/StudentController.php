<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

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

        // Create a new student
        $student = Student::create($validatedData);

        // Return a response
        return response()->json($student, 201);
    }
}

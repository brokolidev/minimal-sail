<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class StudentController extends Controller
{
    public function show(string $studentId)
    {
        $student = Student::findOr($studentId, function() {
            throw new NotFoundHttpException('Student not exists');
        });

        return response()->json([
            'message'   => 'Student retrieved successfully',
            'timestamp' => date('Y-m-d h:i:s'),
            'data'      => $student,
        ], 200);
    }

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
            'student_id'  => 'required|string|max:255',
            'student_name'   => 'required|string|max:255',
            'course_name' => 'required|string|max:255',
            'date' => 'required',
        ]);

        $validatedData['date'] = Carbon::createFromFormat('d/m/Y',
            $validatedData['date'])->format('Y-m-d');


        // Check if a student with the same name already exists
        $existingStudent = Student::where('student_id', $request->student_id)->first();
        if ($existingStudent) {
            throw ValidationException::withMessages([
                'student_id' => 'A student aleady exists.'
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

    public function update(Request $request, string $studentId)
    {
        $student = Student::findOr($studentId, function() {
            throw new NotFoundHttpException('Student not exists');
        });

        // Validate the request data
        $validatedData = $request->validate([
            'student_id'  => 'string|max:255',
            'student_name'   => 'string|max:255',
            'course_name' => 'string|max:255',
        ]);

        // Update the student
        $student->student_id = $validatedData['student_id'] ?? $student->student_id;
        $student->student_name = $validatedData['student_name'] ?? $student->student_name;
        $student->course_name = $validatedData['course_name'] ?? $student->course_name;

        if($student->isDirty()) {
            $student->save();
        }

        // Return a response
        return response()->json([
            'message' => 'Student updated successfully',
            'timestamp' => date('Y-m-d h:i:s'),
            'data' => $student
        ], 200);
    }

    public function delete(string $studentId)
    {
        $student = Student::findOr($studentId, function() {
            throw new NotFoundHttpException('Student not exists');
        });

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully',
            'timestamp' => date('Y-m-d h:i:s'),
            'data' => [],
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')->get();
        return response()->json($enrollments);
    }

    /**
     * @param [type] $id
     */
    public function show(int $id)
    {
        $enrollment = Enrollment::with('student', 'course')->findOrFail($id);
        return response()->json($enrollment);
    }
}

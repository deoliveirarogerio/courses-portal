<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\{CourseController, StudentController, EnrollmentController, UserController};

Route::apiResource('/courses', CourseController::class);
Route::get('/courses/{courseId}/students', [CourseController::class, 'getStudents']);
Route::apiResource('/students', StudentController::class);
Route::apiResource('/enrollments', EnrollmentController::class);
Route::apiResource('/users', UserController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


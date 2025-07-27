<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::get();
        return view('web.pages.courses.index', compact('courses'));
    }

    public function details($id)
    {
        $course = Course::findOrFail($id);
        return view('web.pages.courses.show', compact('course'));
    }
}

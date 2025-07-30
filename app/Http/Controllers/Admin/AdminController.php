<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Module;
use App\Models\Lesson;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.access');
    }

    public function dashboard()
    {
        // Estatísticas
        $totalCourses = Course::count();
        $totalUsers = User::count();
        $totalModules = Module::count();
        $totalLessons = Lesson::count();

        // Dados recentes
        $recentCourses = Course::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalCourses',
            'totalUsers',
            'totalModules',
            'totalLessons',
            'recentCourses',
            'recentUsers'
        ));
    }
} 
<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'ativo')->with('instructor')->get();
        
        // Buscar estatísticas para o header
        $totalCourses = Course::where('status', 'ativo')->count();
        $totalStudents = User::where('type', 'aluno')->count();
        
        return view('web.pages.courses.index', compact('courses', 'totalCourses', 'totalStudents'));
    }

    public function details($id)
    {
        $course = Course::with(['instructor', 'modules.lessons'])->findOrFail($id);
        $relatedCourses = Course::where('status', 'ativo')->where('id', '!=', $id)->with('instructor')->limit(4)->get();
        
        // Buscar uma aula gratuita para demonstração
        $demoLesson = null;
        
        // Debug: verificar se o curso tem módulos
        if ($course->modules && $course->modules->count() > 0) {
            foreach ($course->modules as $module) {
                // Debug: verificar se o módulo tem aulas
                if ($module->lessons && $module->lessons->count() > 0) {
                    $demoLesson = $module->lessons->where('is_free', 1)->where('status', 'active')->first();
                    if ($demoLesson) {
                        break;
                    }
                }
            }
        }
        
        // Debug temporário - remover depois
        // dd([
        //     'course_id' => $course->id,
        //     'modules_count' => $course->modules ? $course->modules->count() : 0,
        //     'first_module_lessons_count' => $course->modules && $course->modules->count() > 0 ? $course->modules->first()->lessons->count() : 0,
        //     'demo_lesson' => $demoLesson ? $demoLesson->title : 'Nenhuma encontrada',
        //     'all_lessons' => $course->modules ? $course->modules->flatMap->lessons->pluck('title', 'is_free') : 'Sem módulos'
        // ]);

        return view('web.pages.courses.show', compact('course', 'relatedCourses', 'demoLesson'));
    }
}

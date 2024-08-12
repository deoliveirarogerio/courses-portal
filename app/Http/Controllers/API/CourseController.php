<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $courses = Course::with('students')->get();
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        /**
         * @param Request $request
         */
        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    /**
     * @param Course $course
     * @return void
     */

     /**
      * @param Course $course
      * @return void
      */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Course $course
     * @return void
     */
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return response()->json($course, 200);
    }

    /**
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Curso não encontrado'], 404);
        }
    
        // Exclui todas as inscrições relacionadas ao curso
        Enrollment::where('course_id', $id)->delete();
    
        try {
            $course->delete();
            return response()->json(['message' => 'Curso excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao excluir o curso', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param [type] $courseId
     * @return void
     */
    public function getStudents($courseId)
    {
        $course = Course::with('students')->find($courseId);

        if (!$course) {
            return response()->json(['message' => 'Curso não encontrado'], 404);
        }

        return response()->json([
            'course' => $course,
            'students' => $course->students
        ]);
    }
}
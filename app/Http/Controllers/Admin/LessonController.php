<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewLessonNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.access');
    }

    public function index()
    {
        $lessons = Lesson::with(['module.course'])->latest()->paginate(5);
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $modules = Module::with('course')->get();
        $courses = Course::all();
        return view('admin.lessons.create', compact('modules', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id' => 'required|exists:modules,id',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string|max:50',
            'order' => 'required|integer|min:1',
        ]);

        // Buscar o módulo para obter o course_id
        $module = Module::findOrFail($request->module_id);
        
        $lesson = Lesson::create([
            'title' => $request->title,
            'description' => $request->description,
            'module_id' => $request->module_id,
            'course_id' => $module->course_id, // Definir course_id através do módulo
            'video_url' => $request->video_url,
            'duration' => $request->duration,
            'order' => $request->order,
        ]);

        Log::info("📚 Lição criada", [
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->course_id,
            'module_id' => $lesson->module_id,
            'title' => $lesson->title
        ]);

        // Após salvar a lição, adicione logs detalhados:
        Log::info("🎯 Iniciando envio de notificações para nova lição", [
            'lesson_id' => $lesson->id,
            'course_id' => $lesson->course_id
        ]);

        // Vamos debugar a query dos estudantes
        Log::info("🔍 Buscando estudantes matriculados", [
            'course_id' => $lesson->course_id
        ]);

        // Primeiro, vamos ver todos os usuários do tipo aluno
        $allStudents = User::where('type', 'aluno')->where('status', 'active')->get();
        Log::info("👥 Todos os estudantes ativos", [
            'total' => $allStudents->count(),
            'student_ids' => $allStudents->pluck('id')->toArray()
        ]);

        // Agora vamos ver as matrículas do curso
        $enrollments = DB::table('enrollments')
            ->where('course_id', $lesson->course_id)
            ->get();
        Log::info("📋 Matrículas do curso", [
            'course_id' => $lesson->course_id,
            'enrollments' => $enrollments->toArray()
        ]);

        // Vamos testar a query com join direto
        $studentsWithJoin = User::where('type', 'aluno')
            ->where('status', 'active')
            ->join('enrollments', 'users.id', '=', 'enrollments.student_id')
            ->where('enrollments.course_id', $lesson->course_id)
            ->select('users.*')
            ->get();

        Log::info("👥 Estudantes com JOIN direto", [
            'total' => $studentsWithJoin->count(),
            'student_ids' => $studentsWithJoin->pluck('id')->toArray()
        ]);

        // Query original
        $students = User::where('type', 'aluno')
            ->where('status', 'active')
            ->whereHas('enrollmentsAsStudent', function ($query) use ($lesson) {
                $query->where('course_id', $lesson->course_id);
            })
            ->get();

        Log::info("👥 Estudantes encontrados", [
            'total_students' => $students->count(),
            'student_ids' => $students->pluck('id')->toArray(),
            'course_id' => $lesson->course_id
        ]);

        // Verificar se há matrículas no curso
        $totalEnrollments = DB::table('enrollments')
            ->where('course_id', $lesson->course_id)
            ->count();

        Log::info("📊 Total de matrículas no curso", [
            'course_id' => $lesson->course_id,
            'total_enrollments' => $totalEnrollments
        ]);

        // Adicione este debug para ver o usuário ID 8
        $user8 = User::find(8);
        Log::info("👤 Usuário ID 8", [
            'user' => $user8 ? $user8->toArray() : 'não encontrado'
        ]);

        // Vamos buscar estudantes matriculados sem filtro de status
        $studentsAnyStatus = User::where('type', 'aluno')
            ->whereHas('enrollmentsAsStudent', function ($query) use ($lesson) {
                $query->where('course_id', $lesson->course_id);
            })
            ->get();

        Log::info("👥 Estudantes matriculados (qualquer status)", [
            'total' => $studentsAnyStatus->count(),
            'students' => $studentsAnyStatus->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'type' => $user->type,
                    'status' => $user->status
                ];
            })->toArray()
        ]);

        foreach ($students as $student) {
            try {
                Log::info("📤 Enviando notificação para estudante", [
                    'student_id' => $student->id,
                    'student_name' => $student->name
                ]);
                
                $student->notify(new NewLessonNotification(
                    'Uma nova lição foi publicada!',
                    route('student.dashboard', $lesson->id)
                ));
                
                Log::info("✅ Notificação enviada com sucesso", [
                    'student_id' => $student->id
                ]);
            } catch (\Exception $e) {
                Log::error("❌ Erro ao enviar notificação", [
                    'student_id' => $student->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info("🏁 Processo de notificações concluído");

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Aula criada com sucesso!');
    }

    public function show(Lesson $lesson)
    {
        $lesson->load(['module.course']);
        return view('admin.lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $modules = Module::with('course')->get();
        $courses = Course::all();
        return view('admin.lessons.edit', compact('lesson', 'modules', 'courses'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id' => 'required|exists:modules,id',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|string|max:50',
            'order' => 'required|integer|min:1',
        ]);

        $lesson->update($request->all());

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Aula excluída com sucesso!');
    }
} 

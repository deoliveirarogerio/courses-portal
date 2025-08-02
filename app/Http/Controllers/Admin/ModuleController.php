<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewModuleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.access');
    }

    public function index()
    {
        $modules = Module::with(['course', 'lessons'])->latest()->paginate(5);
        return view('admin.modules.index', compact('modules'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.modules.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'order' => 'required|integer|min:1',
        ]);

        $module = Module::create($request->all());

        Log::info("📚 Módulo criado", [
            'module_id' => $module->id,
            'course_id' => $module->course_id,
            'title' => $module->title
        ]);

        // Enviar notificações para estudantes matriculados
        Log::info("🎯 Iniciando envio de notificações para novo módulo", [
            'module_id' => $module->id,
            'course_id' => $module->course_id
        ]);

        $students = User::where('type', 'aluno')
            ->where('status', 'active')
            ->whereHas('enrollmentsAsStudent', function ($query) use ($module) {
                $query->where('course_id', $module->course_id);
            })
            ->get();

        Log::info("👥 Estudantes encontrados para notificação de módulo", [
            'total_students' => $students->count(),
            'student_ids' => $students->pluck('id')->toArray(),
            'course_id' => $module->course_id
        ]);

        foreach ($students as $student) {
            try {
                Log::info("📤 Enviando notificação de módulo para estudante", [
                    'student_id' => $student->id,
                    'student_name' => $student->name
                ]);
                
                $student->notify(new NewModuleNotification(
                    'Um novo módulo foi adicionado: ' . $module->title,
                    route('student.dashboard')
                ));
                
                Log::info("✅ Notificação de módulo enviada com sucesso", [
                    'student_id' => $student->id
                ]);
            } catch (\Exception $e) {
                Log::error("❌ Erro ao enviar notificação de módulo", [
                    'student_id' => $student->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        Log::info("🏁 Processo de notificações de módulo concluído");

        return redirect()->route('admin.modules.index')
            ->with('success', 'Módulo criado com sucesso!');
    }

    public function show(Module $module)
    {
        $module->load(['course', 'lessons']);
        return view('admin.modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        $courses = Course::all();
        return view('admin.modules.edit', compact('module', 'courses'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'order' => 'required|integer|min:1',
        ]);

        $module->update($request->all());

        return redirect()->route('admin.modules.index')
            ->with('success', 'Módulo atualizado com sucesso!');
    }

    public function destroy(Module $module)
    {
        $module->delete();

        return redirect()->route('admin.modules.index')
            ->with('success', 'Módulo excluído com sucesso!');
    }
} 

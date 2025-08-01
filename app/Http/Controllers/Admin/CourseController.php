<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.access');
    }

    public function index()
    {
        $courses = Course::with('modules')->latest()->paginate(5);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $instructors = User::where('type', 'instrutor')->get();
        return view('admin.courses.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'curriculum' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'difficulty_level' => 'required|in:iniciante,intermediario,avancado',
            'max_students' => 'required|integer|min:1',
            'status' => 'required|in:ativo,inativo,rascunho',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['remaining_slots'] = $request->max_students;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('courses', $imageName, 'public');
            $data['image'] = $imageName;
        }

        Course::create($data);

        // Debug da consulta de estudantes
        \Log::info("🔍 Buscando estudantes...");
        \Log::info("🔍 Query: User::where('type', 'aluno')->where('status', 'ativo')");

        $students = User::where('type', 'aluno')->where('status', 'active')->get();

        \Log::info("📊 Resultado da busca", [
            'total_students' => $students->count(),
            'students' => $students->pluck('id', 'name')->toArray()
        ]);

        // Se não encontrou nenhum, vamos ver todos os usuários
        if ($students->count() === 0) {
            $allUsers = User::all();
            \Log::info("🔍 Todos os usuários no sistema", [
                'total' => $allUsers->count(),
                'users' => $allUsers->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'type' => $user->type,
                        'status' => $user->status ?? 'sem status'
                    ];
                })->toArray()
            ]);
        }

        \Log::info("📧 Enviando notificações para " . $students->count() . " estudantes");

        foreach ($students as $student) {
            try {
                $student->notify(new NewCourseNotification(
                    'Um novo curso foi criado: ' . $request->title,
                    route('student.courses')
                ));
                \Log::info("✅ Notificação enviada para: " . $student->name . " (ID: {$student->id})");
            } catch (\Exception $e) {
                \Log::error("❌ Erro ao enviar notificação para {$student->name}: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso criado com sucesso!');
    }

    public function show(Course $course)
    {
        $course->load('modules.lessons');
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $instructors = User::where('type', 'instrutor')->get(); 
        return view('admin.courses.edit', compact('course', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'curriculum' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|string|max:100',
            'difficulty_level' => 'required|in:iniciante,intermediario,avancado',
            'max_students' => 'required|integer|min:1',
            'status' => 'required|in:ativo,inativo,rascunho',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            // Remover imagem anterior
            if ($course->image && Storage::disk('public')->exists('courses/' . $course->image)) {
                Storage::disk('public')->delete('courses/' . $course->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('courses', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Course $course)
    {
        // Remover imagem se existir
        if ($course->image && Storage::disk('public')->exists('courses/' . $course->image)) {
            Storage::disk('public')->delete('courses/' . $course->image);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso excluído com sucesso!');
    }
} 


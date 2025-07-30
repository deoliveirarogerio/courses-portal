<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.access');
    }

    public function index()
    {
        $lessons = Lesson::with(['module.course'])->latest()->paginate(15);
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

        Lesson::create($request->all());

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
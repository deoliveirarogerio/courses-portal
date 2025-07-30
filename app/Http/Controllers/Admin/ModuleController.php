<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.admin.access');
    }

    public function index()
    {
        $modules = Module::with(['course', 'lessons'])->latest()->paginate(15);
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

        Module::create($request->all());

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
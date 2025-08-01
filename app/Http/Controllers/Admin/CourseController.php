<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
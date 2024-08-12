<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        return response()->json(Student::all());
    }

    /**
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        return response()->json(Student::findOrFail($id));
    }

    /**
     * @param [type] $id
     * @return void
     */
    public function edit($id)
    {
        return response()->json(Student::findOrFail($id));
    }


    /**
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'status' => 'required',
        ]);
    
        $student = Student::create($request->all());
    
        return response()->json($student, 201);
    }

    /**
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return response()->json(['message' => 'Estudante excluído com sucesso.']);
    }
}

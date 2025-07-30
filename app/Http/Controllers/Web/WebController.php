<?php

namespace App\Http\Controllers\Web;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'ativo')->orderBy('created_at', 'desc')->get();
        $instructors = User::where('type', 'instrutor')->get();
        return view('web.pages.home', compact('courses', 'instructors'));
    }

    public function about()
    {
        return view('web.pages.about');
    }

    public function contact()
    {
        return view('web.pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        // Aqui você pode implementar o envio do e-mail
        // Por exemplo: Mail::to('contato@portaldecursos.com')->send(new ContactMail($request->all()));

        return response()->json([
            'success' => true,
            'message' => 'Mensagem enviada com sucesso!'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CourseCompleted;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the student dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get student statistics
        $enrolledCourses = 5; // This would come from database
        $completedCourses = 2;
        $certificates = 2;
        $studyHours = 48;

        return view('student.dashboard', compact(
            'enrolledCourses',
            'completedCourses',
            'certificates',
            'studyHours'
        ));
    }

    public function markAsRead($id)
{
    $notification = auth()->user()->notifications()->where('id', $id)->first();
    if ($notification) {
        $notification->markAsRead();
    }

    return response()->json(['success' => true]);
}


    /**
     * Show the student certificates page.
     */
    public function certificates()
    {
        $user = Auth::user();

        // Get certificate statistics
        $totalCertificates = 2;
        $totalDownloads = 8;
        $totalShares = 3;
        $totalHours = 45;

        return view('student.certificates', compact(
            'totalCertificates',
            'totalDownloads',
            'totalShares',
            'totalHours'
        ));
    }

    /**
     * Show the student progress page.
     */
    public function progress()
    {
        $user = Auth::user();

        // Get progress statistics
        $totalLessons = 87;
        $studyHours = 48;
        $streak = 7;
        $avgScore = 92;

        return view('student.progress', compact(
            'totalLessons',
            'studyHours',
            'streak',
            'avgScore'
        ));
    }

    /**
     * Show student profile.
     */
    public function profile()
    {
        $user = Auth::user();

        // Buscar ou criar perfil de estudante
        $student = $user->student;
        if (!$student) {
            $student = $user->student()->create([
                'name' => $user->name,
                'email' => $user->email,
                'interests' => ['Desenvolvimento Web'], // Interesse padrão
            ]);
        }

        // Estatísticas para o perfil (implementar lógica real depois)
        $enrolledCourses = 5;
        $certificates = 2;
        $studyHours = 48;

        // Dados do perfil vindos do model student
        $phone = $student->phone;
        $birthDate = $student->birth_date_formatted;
        $city = $student->city;
        $profession = $student->profession;

        return view('student.profile', compact(
            'user',
            'student',
            'enrolledCourses',
            'certificates',
            'studyHours',
            'phone',
            'birthDate',
            'city',
            'profession'
        ));
    }

    /**
     * Update student profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $student = $user->student ?: $user->student()->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'profession' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
            'interests' => 'nullable|array',
            'experience_level' => 'nullable|in:iniciante,intermediario,avancado',
            'preferred_time' => 'nullable|in:manha,tarde,noite,madrugada',
            'weekly_goal_hours' => 'nullable|integer|min:1|max:168',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Atualizar dados do usuário
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Atualizar dados do estudante
        $student->update([
            'name' => $request->name, // Manter sincronizado
            'email' => $request->email, // Manter sincronizado
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'city' => $request->city,
            'state' => $request->state,
            'profession' => $request->profession,
            'bio' => $request->bio,
            'interests' => $request->interests ?? [],
            'experience_level' => $request->experience_level ?? 'iniciante',
            'preferred_time' => $request->preferred_time ?? 'noite',
            'weekly_goal_hours' => $request->weekly_goal_hours ?? 20,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso!'
        ]);
    }

    /**
     * Update avatar.
     */
    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Por favor, envie uma imagem válida (máximo 2MB).'
            ], 422);
        }

        $user = Auth::user();
        $student = $user->student ?: $user->student()->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        // Remover avatar anterior se existir
        if ($student->avatar && Storage::disk('public')->exists('avatars/' . $student->avatar)) {
            Storage::disk('public')->delete('avatars/' . $student->avatar);
        }

        // Salvar novo avatar
        $file = $request->file('avatar');
        $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $file->storeAs('avatars', $fileName, 'public');

        $student->update(['avatar' => $fileName]);

        return response()->json([
            'success' => true,
            'message' => 'Avatar atualizado com sucesso!',
            'avatar_url' => $student->avatar_url
        ]);
    }

    /**
     * Change password.
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'A senha atual é obrigatória.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'new_password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'A senha atual está incorreta.'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Senha alterada com sucesso!'
        ]);
    }

    /**
     * Download a certificate.
     */
    public function downloadCertificate($certificateId)
    {
        // In a real application, you would:
        // 1. Verify the certificate belongs to the authenticated user
        // 2. Generate or retrieve the certificate PDF
        // 3. Return the file download response

        // For now, we'll just redirect back with a success message
        return redirect()->back()->with('success', 'Certificado baixado com sucesso!');
    }

    /**
     * View a certificate.
     */
    public function viewCertificate($certificateId)
    {
        // In a real application, you would:
        // 1. Verify the certificate belongs to the authenticated user
        // 2. Fetch the certificate from database
        // $certificate = Certificate::where('id', $certificateId)
        //     ->where('student_id', auth()->id())
        //     ->with(['course', 'student', 'course.instructor'])
        //     ->firstOrFail();

        // For now, we'll create mock data
        $certificate = new \stdClass();
        $certificate->id = $certificateId;
        $certificate->verification_code = 'PC' . strtoupper(substr(md5($certificateId), 0, 8));
        $certificate->final_grade = '9.5';
        $certificate->issued_at = now();
        $certificate->completion_date = now()->subDays(5);
        $certificate->start_date = now()->subMonths(3);

        // Mock student data
        $certificate->student = new \stdClass();
        $certificate->student->name = auth()->user()->name ?? 'João Silva Santos';

        // Mock course data
        $certificate->course = new \stdClass();
        $certificate->course->title = 'Desenvolvimento Web Completo com PHP e Laravel';
        $certificate->course->duration = '120';

        // Mock instructor data
        $certificate->course->instructor = new \stdClass();
        $certificate->course->instructor->name = 'Prof. Maria Silva';

        return view('student.certificate-view', compact('certificate'));
    }


    /**
     * Verify a certificate by number.
     */
    public function verifyCertificate(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string'
        ]);

        // In a real application, you would look up the certificate in the database
        // For now, we'll return a mock response

        return response()->json([
            'success' => true,
            'certificate' => [
                'number' => $request->certificate_number,
                'course' => 'Fundamentos do JavaScript',
                'student' => 'João da Silva',
                'completion_date' => '2024-01-15',
                'duration' => '20 horas',
                'verified' => true
            ]
        ]);
    }

    /**
     * Update notifications preferences.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        $student = $user->student ?: $user->student()->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $student->update([
            'email_notifications' => $request->has('email_notifications'),
            'course_reminders' => $request->has('course_reminders'),
            'progress_updates' => $request->has('progress_updates'),
            'marketing_emails' => $request->has('marketing_emails'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Preferências de notificação atualizadas!'
        ]);
    }

    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $user = Auth::user();
        $student = $user->student ?: $user->student()->create([
            'name' => $user->name,
            'email' => $user->email,
        ]);

        $student->update([
            'public_profile' => $request->has('public_profile'),
            'show_progress' => $request->has('show_progress'),
            'show_certificates' => $request->has('show_certificates'),
            'allow_messages' => $request->has('allow_messages'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Configurações de privacidade atualizadas!'
        ]);
    }

    /**
     * Get study statistics for charts.
     */
    public function getStudyStats(Request $request)
    {
        $period = $request->get('period', '30'); // days

        // In a real application, you would query the database for actual statistics
        // For now, we'll return mock data

        return response()->json([
            'daily_hours' => [2, 3, 1, 4, 2, 1, 5],
            'weekly_progress' => [18, 20],
            'course_completion' => [
                'Laravel' => 75,
                'JavaScript' => 45,
                'UI/UX' => 30,
                'HTML/CSS' => 100
            ],
            'time_distribution' => [
                'morning' => 20,
                'afternoon' => 30,
                'evening' => 50
            ]
        ]);
    }

// Adicionar estes métodos ao StudentController existente



/**
 * Show student courses.
 */
public function courses()
{
    $user = Auth::user();
    $student = $user->getOrCreateStudentProfile();

    // IDs dos cursos já matriculados
    $enrolledCourseIds = $student->enrolledCourses()->pluck('courses.id')->toArray();

    // Cursos disponíveis (ativos e com vagas), excluindo os já matriculados
    $availableCourses = \App\Models\Course::active()
        ->withAvailableSlots()
        ->whereNotIn('id', $enrolledCourseIds)
        ->latest()
        ->get();

    // Cursos em destaque (também não mostrar se já matriculado)
    $featuredCourses = \App\Models\Course::active()
        ->featured()
        ->withAvailableSlots()
        ->whereNotIn('id', $enrolledCourseIds)
        ->take(3)
        ->get();

    // Cursos matriculados (join com enrollments)
    $enrolledCourses = $student->enrolledCourses()->with(['students'])->get();

    return view('student.courses', compact(
        'user',
        'student',
        'availableCourses',
        'enrolledCourses',
        'featuredCourses'
    ));
}

/**
 * Show course details for student.
 */
public function courseDetail($id)
{
    $user = Auth::user();
    $student = $user->getOrCreateStudentProfile();
    $course = \App\Models\Course::with(['modules.lessons'])->findOrFail($id);

    // Verificar se já está matriculado
    $isEnrolled = $student->enrolledCourses()->where('course_id', $id)->exists();

    // Buscar módulos e aulas reais
    $modules = $course->modules;

    return view('student.course-detail', compact(
        'user',
        'student',
        'course',
        'isEnrolled',
        'modules'
    ));
}

/**
 * Enroll student in course.
 */
public function enrollCourse(Request $request, $id)
{
    $user = Auth::user();
    $student = $user->getOrCreateStudentProfile();
    $course = Course::findOrFail($id);

    if (!$course->isRegistrationOpen()) {
        return response()->json([
            'success' => false,
            'message' => 'As inscrições para este curso não estão abertas.'
        ], 422);
    }

    // Verifica se o estudante já está matriculado
    if ($student->enrolledCourses()->where('course_id', $id)->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'Você já está matriculado neste curso.'
        ], 422);
    }

    // Efetua a matrícula
    $student->enrolledCourses()->attach($course->id, [
        'progress' => 0,
        'last_accessed' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Matrícula realizada com sucesso!'
    ]);
    }
}
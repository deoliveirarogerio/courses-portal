<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
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

    /**
     * Show the student courses page.
     */
    public function courses()
    {
        $user = Auth::user();

        // In a real application, you would fetch the user's enrolled courses
        // $courses = $user->enrollments()->with('course')->get();

        return view('student.courses');
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
     * Show the student profile page.
     */
    public function profile()
    {
        $user = Auth::user();

        // Get profile statistics
        $enrolledCourses = 5;
        $certificates = 2;
        $studyHours = 48;

        // Additional profile data (in a real app, these would come from a profile model)
        $phone = '(11) 99999-9999';
        $birthDate = '15/03/1990';
        $city = 'São Paulo, SP';
        $profession = 'Desenvolvedor Web';

        return view('student.profile', compact(
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
     * Update the student profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'city' => 'nullable|string|max:100',
            'profession' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // In a real application, you would update additional profile fields
        // in a separate profile model or user profile table

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso!'
        ]);
    }

    /**
     * Change the student password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Senha atual incorreta.'
            ], 400);
        }

        // Update password
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
     * Update notification preferences.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        // In a real application, you would save these preferences
        // to a user_preferences table or similar

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

        // In a real application, you would save these settings
        // to a user_settings table or similar

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
}

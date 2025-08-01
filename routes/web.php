<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\{
    WebController,
    CourseController,
};
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};

use App\Http\Controllers\Student\NotificationController;
use App\Http\Controllers\Student\StudentNotificationController;

// Public web routes
Route::controller(WebController::class)->name('web.')->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/cursos', 'courses')->name('courses');
    Route::get('/curso/{id}', 'courseDetail')->name('course.detail');
    Route::get('/sobre-nós', 'about')->name('about');
    Route::get('/fale-conosco', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit')->name('contact.submit');
});

// Legacy course routes (keeping for compatibility)
Route::controller(CourseController::class)->name('web.courses.')->group(function () {
    Route::get('/cursos', 'index')->name('index');
    Route::get('/curso/{id}', 'details')->name('details');
});

// Authentication routes (custom)
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']); // Rota POST para processar o registro

    // Custom named routes (for compatibility with your theme)
    Route::get('/entrar', [LoginController::class, 'showLoginForm'])->name('web.login');
    Route::post('/entrar', [LoginController::class, 'login'])->name('web.login.submit'); // ADICIONADA ESTA LINHA
    Route::get('/cadastro', [RegisterController::class, 'showRegistrationForm'])->name('web.register');
    Route::post('/cadastro', [RegisterController::class, 'register']); // Rota POST para processar cadastro
});

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Student dashboard routes (protected by auth and user type middleware)
Route::group(['prefix' => 'student', 'as' => 'student.', 'middleware' => ['auth', 'check.user.type:aluno']], function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::post('/courses/{id}/enroll', [StudentController::class, 'enrollCourse'])->name('courses.enroll');
    Route::get('/certificates', [StudentController::class, 'certificates'])->name('certificates');
    Route::get('/progress', [StudentController::class, 'progress'])->name('progress');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::get('/courses/{id}/detail', [StudentController::class, 'courseDetail'])->name('course.detail');

    // Profile management
    Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [StudentController::class, 'updateAvatar'])->name('profile.avatar'); // Nova rota
    Route::post('/profile/change-password', [StudentController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/profile/notifications', [StudentController::class, 'updateNotifications'])->name('profile.notifications');
    Route::post('/profile/privacy', [StudentController::class, 'updatePrivacy'])->name('profile.privacy');

    // Certificates
    Route::get('/certificates/{id}/download', [StudentController::class, 'downloadCertificate'])->name('certificates.download');
    Route::get('/certificates/{id}/view', [StudentController::class, 'viewCertificate'])->name('certificates.view');
    Route::post('/certificates/verify', [StudentController::class, 'verifyCertificate'])->name('certificates.verify');

    // Notificações
    Route::get('/notifications', [StudentNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-as-read', [StudentNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-selected-as-read', [StudentNotificationController::class, 'markSelectedAsRead'])->name('notifications.markSelectedAsRead');
    // Statistics
    Route::get('/stats', [StudentController::class, 'getStudyStats'])->name('stats');
});

// Home redirect for authenticated users
//Route::get('/home', function () {
//    return redirect()->route('student.dashboard');
//})->middleware('auth')->name('home');

// Admin routes (accessible by admin and instructor)
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'check.admin.access']], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // Courses
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);

    // Modules
    Route::resource('modules', App\Http\Controllers\Admin\ModuleController::class);

    // Lessons
    Route::resource('lessons', App\Http\Controllers\Admin\LessonController::class);

    // Users
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});








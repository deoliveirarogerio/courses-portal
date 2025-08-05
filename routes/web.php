<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
    WebController,
    CourseController,
};
use App\Http\Controllers\Student\{
    StudentController,
    ChatController,
    NotificationController,
    StudentNotificationController
};

use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};

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
    Route::post('/profile/avatar', [StudentController::class, 'updateAvatar'])->name('profile.avatar');
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
    
    // Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/room/{room}', [ChatController::class, 'show'])->name('chat.room');
    Route::post('/chat/join/{room}', [ChatController::class, 'joinRoom'])->name('chat.join');
    Route::post('/chat/leave/{room}', [ChatController::class, 'leaveRoom'])->name('chat.leave');
    Route::post('/chat/send/{room}', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/create', [ChatController::class, 'createRoom'])->name('chat.create');
    Route::post('/chat/update-last-seen/{room}', [ChatController::class, 'updateLastSeen'])->name('chat.updateLastSeen');

    // Fórum routes
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\ForumController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Student\ForumController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Student\ForumController::class, 'store'])->name('store');
        Route::get('/category/{id}', [App\Http\Controllers\Student\ForumController::class, 'category'])->name('category');
        Route::get('/topic/{id}', [App\Http\Controllers\Student\ForumController::class, 'show'])->name('topic');
        Route::post('/topic/{id}/reply', [App\Http\Controllers\Student\ForumController::class, 'reply'])->name('reply');
        Route::post('/post/{id}/like', [App\Http\Controllers\Student\ForumController::class, 'likePost'])->name('post.like');
        Route::post('/post/{id}/solution', [App\Http\Controllers\Student\ForumController::class, 'markAsSolution'])->name('post.solution');
    });
});

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




















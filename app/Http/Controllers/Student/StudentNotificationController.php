<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentNotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(3);
        return view('student.notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('student.notifications.index')->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function markSelectedAsRead(Request $request)
    {
        $ids = $request->input('notification_ids', []);
        if (!empty($ids)) {
            Auth::user()->notifications()->whereIn('id', $ids)->update(['read_at' => now()]);
        }
        return redirect()->route('student.notifications.index')->with('success', 'Notificações selecionadas foram marcadas como lidas.');
    }
}

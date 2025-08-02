<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class StudentNotificationController extends Controller
{
    public function index()
    {
      
        $user = Auth::user();         
        // Tentar acessar notificações diretamente
        try {
            $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);
        } catch (\Exception $e) {
            $allNotifications = collect(); // Collection vazia
        }

        
        return view('student.notifications.index', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('student.notifications.index')->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        
        return response()->json(['success' => true, 'message' => 'Notificação marcada como lida']);
    }

    public function markSelectedAsRead(Request $request)
    {
        $ids = $request->input('notification_ids', []);
        if (!empty($ids)) {
            Auth::user()->notifications()->whereIn('id', $ids)->update(['read_at' => now()]);
        }
        
        return response()->json(['success' => true, 'message' => 'Notificações marcadas como lidas']);
    }
}














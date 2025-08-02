<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $notifications = DB::table('notifications')->get();
        
        foreach ($notifications as $notification) {
            $data = json_decode($notification->data, true);
            
            // Corrigir URLs baseado no tipo de notificação
            if (str_contains($data['message'], 'curso')) {
                $data['url'] = route('student.courses');
            } elseif (str_contains($data['message'], 'certificado')) {
                $data['url'] = route('student.certificates');
            } else {
                $data['url'] = route('student.dashboard');
            }
            
            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['data' => json_encode($data)]);
        }
    }
};
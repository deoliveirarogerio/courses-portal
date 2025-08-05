<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'course_id',
        'created_by',
        'is_active',
        'max_participants'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function participants()
    {
        return $this->hasMany(ChatParticipant::class, 'room_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'room_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'room_id')->latest();
    }

    public function canJoin($userId)
    {
        // Se for sala pública, qualquer um pode entrar
        if ($this->type === 'public') {
            return true;
        }

        // Se for sala de curso, verificar se o usuário está matriculado
        if ($this->type === 'course' && $this->course_id) {
            return $this->course->enrollments()->where('student_id', $userId)->exists();
        }

        // Se for sala privada, verificar se foi convidado (implementar depois)
        if ($this->type === 'private') {
            return false; // Por enquanto, salas privadas não permitem entrada
        }

        return false;
    }

    public function isParticipant($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    public function unreadMessagesCount($userId)
    {
        $participant = $this->participants()->where('user_id', $userId)->first();
        
        if (!$participant) {
            return 0;
        }

        return $this->messages()
            ->where('created_at', '>', $participant->last_seen_at ?? $participant->joined_at)
            ->where('user_id', '!=', $userId)
            ->count();
    }
}




<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\ChatParticipant;
use App\Events\MessageSent;
use App\Events\UserJoinedRoom;
use App\Events\UserLeftRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Salas que o usuário participa
        $myRooms = ChatRoom::whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['latestMessage.user', 'participants.user'])->get();
        
        // Salas públicas disponíveis
        $publicRooms = ChatRoom::where('type', 'public')
                              ->where('is_active', true)
                              ->whereDoesntHave('participants', function($query) use ($user) {
                                  $query->where('user_id', $user->id);
                              })
                              ->with(['participants.user'])
                              ->get();
        
        // Salas de cursos que o usuário está matriculado
        $courseRooms = ChatRoom::where('type', 'course')
                              ->where('is_active', true)
                              ->whereHas('course.enrollments', function($query) use ($user) {
                                  $query->where('student_id', $user->id); // Mudança aqui: user_id -> student_id
                              })
                              ->whereDoesntHave('participants', function($query) use ($user) {
                                  $query->where('user_id', $user->id);
                              })
                              ->with(['course', 'participants.user'])
                              ->get();

        return view('student.chat.index', compact('myRooms', 'publicRooms', 'courseRooms'));
    }

    public function show($roomId)
    {
        $room = ChatRoom::with(['participants.user', 'course'])->findOrFail($roomId);
        $user = auth()->user();
        
        // Verificar se o usuário pode acessar a sala
        if (!$room->canJoin($user->id) && !$room->isParticipant($user->id)) {
            return redirect()->route('student.chat.index')
                           ->with('error', 'Você não tem permissão para acessar esta sala.');
        }
        
        // Adicionar usuário como participante se não estiver
        if (!$room->isParticipant($user->id)) {
            $this->joinRoom($room, $user);
        }
        
        // Atualizar última visualização
        $participant = $room->participants()->where('user_id', $user->id)->first();
        $participant->updateLastSeen();
        
        // Buscar mensagens
        $messages = $room->messages()
                        ->with(['user', 'replyTo.user'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(50);
        
        // Marcar mensagens como lidas
        foreach ($messages as $message) {
            if ($message->user_id !== $user->id) {
                $message->markAsRead($user->id);
            }
        }

        return view('student.chat.room', compact('room', 'messages'));
    }

    public function sendMessage(Request $request, $roomId)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
                'reply_to' => 'nullable|exists:chat_messages,id',
                'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx'
            ]);

            $room = ChatRoom::findOrFail($roomId);
            $user = auth()->user();
            
            if (!$room->isParticipant($user->id)) {
                return response()->json(['error' => 'Você não é participante desta sala'], 403);
            }

            $messageData = [
                'room_id' => $roomId,
                'user_id' => $user->id,
                'message' => $request->message,
                'type' => 'text',
                'reply_to' => $request->reply_to
            ];

            $message = ChatMessage::create($messageData);
            $message->load('user', 'replyTo.user');

            // Broadcast da mensagem
            broadcast(new MessageSent($message))->toOthers();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao enviar mensagem:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Erro ao enviar mensagem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function joinRoom($roomId)
    {
        Log::info('ChatController joinRoom chamado', ['roomId' => $roomId]);
        
        try {
            $room = ChatRoom::findOrFail($roomId);
            $user = auth()->user();
            
            if (!$user) {
                Log::error('Usuário não autenticado no joinRoom');
                return response()->json(['error' => 'Usuário não autenticado'], 401);
            }
            
            Log::info('Verificando acesso à sala', [
                'room_id' => $room->id,
                'user_id' => $user->id,
                'room_type' => $room->type
            ]);
            
            if (!$room->canJoin($user->id)) {
                Log::error('Usuário não pode entrar na sala', [
                    'room_id' => $room->id,
                    'user_id' => $user->id
                ]);
                return response()->json(['error' => 'Não é possível entrar nesta sala'], 403);
            }
            
            if ($room->isParticipant($user->id)) {
                Log::warning('Usuário já é participante', [
                    'room_id' => $room->id,
                    'user_id' => $user->id
                ]);
                return response()->json(['error' => 'Você já é participante desta sala'], 400);
            }

            ChatParticipant::create([
                'room_id' => $room->id,
                'user_id' => $user->id,
                'joined_at' => now(),
                'last_seen_at' => now()
            ]);

            Log::info('Usuário entrou na sala com sucesso', [
                'room_id' => $room->id,
                'user_id' => $user->id
            ]);

            // Broadcast que usuário entrou
            broadcast(new UserJoinedRoom($user, $room));

            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Erro no joinRoom', [
                'roomId' => $roomId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'Erro interno do servidor'], 500);
        }
    }

    public function leaveRoom($roomId)
    {
        $room = ChatRoom::findOrFail($roomId);
        $user = auth()->user();
        
        $participant = $room->participants()->where('user_id', $user->id)->first();
        
        if (!$participant) {
            return response()->json(['error' => 'Você não é participante desta sala'], 400);
        }

        $participant->delete();

        // Broadcast que usuário saiu
        broadcast(new UserLeftRoom($user, $room));

        return response()->json(['success' => true]);
    }

    public function loadMessages($roomId)
    {
        $room = ChatRoom::findOrFail($roomId);
        $user = auth()->user();
        
        if (!$room->isParticipant($user->id)) {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        $page = request('page', 1);
        $messages = $room->messages()
                        ->with(['user', 'replyTo.user'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'messages' => $messages->items(),
            'has_more' => $messages->hasMorePages()
        ]);
    }

    public function updateLastSeen($roomId)
    {
        $room = ChatRoom::findOrFail($roomId);
        $user = auth()->user();
        
        $participant = $room->participants()->where('user_id', $user->id)->first();
        
        if ($participant) {
            $participant->updateLastSeen();
        }

        return response()->json(['success' => true]);
    }

    public function createRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:public,private',
            'max_participants' => 'nullable|integer|min:2|max:100'
        ]);

        $room = ChatRoom::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'created_by' => auth()->id(),
            'max_participants' => $request->max_participants,
            'is_active' => true
        ]);

        // Adicionar o criador como participante e admin
        ChatParticipant::create([
            'room_id' => $room->id,
            'user_id' => auth()->id(),
            'joined_at' => now(),
            'last_seen_at' => now(),
            'is_admin' => true
        ]);

        return redirect()->route('student.chat.room', $room->id)
                       ->with('success', 'Sala criada com sucesso!');
    }
}








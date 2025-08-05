<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumTopic;
use App\Models\ForumPost;
use App\Models\ForumAttachment;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::where('is_active', true)
            ->withCount('topics')
            ->with('latestTopics.user')
            ->orderBy('sort_order')
            ->get();

        $recentTopics = ForumTopic::with(['user', 'category', 'latestPost.user'])
            ->orderBy('last_activity_at', 'desc')
            ->limit(10)
            ->get();

        return view('student.forum.index', compact('categories', 'recentTopics'));
    }

    public function category($id)
    {
        $category = ForumCategory::findOrFail($id);
        
        $topics = ForumTopic::where('category_id', $id)
            ->with(['user', 'latestPost.user'])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('last_activity_at', 'desc')
            ->paginate(20);

        return view('student.forum.category', compact('category', 'topics'));
    }

    public function show($id)
    {
        $topic = ForumTopic::with(['user', 'category', 'course'])
            ->findOrFail($id);
        
        $topic->incrementViews();
        
        $posts = ForumPost::where('topic_id', $id)
            ->with(['user', 'attachments'])
            ->orderBy('created_at')
            ->paginate(10);

        return view('student.forum.topic', compact('topic', 'posts'));
    }

    public function create()
    {
        $categories = ForumCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('student.forum.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $topic = ForumTopic::create([
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'last_activity_at' => now()
        ]);

        return redirect()->route('student.forum.topic', $topic->id)
            ->with('success', 'Tópico criado com sucesso!');
    }

    public function reply(Request $request, $topicId)
    {
        $request->validate([
            'content' => 'required|string',
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'
        ]);

        $topic = ForumTopic::findOrFail($topicId);
        
        if ($topic->is_locked) {
            return back()->with('error', 'Este tópico está bloqueado.');
        }

        $post = ForumPost::create([
            'topic_id' => $topicId,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        // Processar anexos se houver
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('forum/attachments', $filename, 'public');
                
                ForumAttachment::create([
                    'post_id' => $post->id,
                    'filename' => $filename,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'path' => $path
                ]);
            }
        }

        // Atualizar última atividade do tópico
        $topic->update(['last_activity_at' => now()]);

        return back()->with('success', 'Resposta enviada com sucesso!');
    }

    public function likePost($postId)
    {
        $post = ForumPost::findOrFail($postId);
        $post->increment('likes_count');
        
        return response()->json(['success' => true, 'likes' => $post->likes_count]);
    }

    public function markAsSolution($postId)
    {
        $post = ForumPost::findOrFail($postId);
        $topic = $post->topic;
        
        // Verificar se o usuário pode marcar como solução
        if (auth()->id() !== $topic->user_id && auth()->user()->type !== 'instrutor') {
            return response()->json(['success' => false, 'message' => 'Sem permissão']);
        }
        
        // Remover solução anterior se houver
        ForumPost::where('topic_id', $topic->id)->update(['is_solution' => false]);
        
        // Marcar nova solução
        $post->update(['is_solution' => true]);
        $topic->update(['is_solved' => true]);
        
        return response()->json(['success' => true]);
    }
}



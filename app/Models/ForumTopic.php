<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'course_id',
        'title',
        'content',
        'is_pinned',
        'is_locked',
        'is_solved',
        'views_count',
        'last_activity_at'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'is_solved' => 'boolean',
        'last_activity_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'topic_id');
    }

    public function latestPost()
    {
        return $this->hasOne(ForumPost::class, 'topic_id')->latest();
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function topics()
    {
        return $this->hasMany(ForumTopic::class, 'category_id');
    }

    public function latestTopics()
    {
        return $this->hasMany(ForumTopic::class, 'category_id')
                   ->orderBy('last_activity_at', 'desc')
                   ->limit(5);
    }
}
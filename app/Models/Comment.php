<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'body',
        'is_active',
        'parent_id', // <-- اضافه شد
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // =================================================================
    // Relationships
    // =================================================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    // --- برای پاسخ‌ها ---

    /**
     * Get the parent comment.
     * (نظر اصلی که این نظر، پاسخی به آن است)
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get all replies for the comment.
     * (تمام پاسخ‌های این نظر)
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}

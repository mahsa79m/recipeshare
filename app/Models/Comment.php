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
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'body',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // =================================================================
    // Relationships
    // =================================================================

    /**
     * Get the user that owns the comment.
     * (کاربری که این نظر را ثبت کرده است)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the recipe that the comment belongs to.
     * (دستور غذایی که این نظر برای آن ثبت شده است)
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}

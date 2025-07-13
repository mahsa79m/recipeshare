<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
    ];

    // =================================================================
    // Relationships
    // =================================================================

    /**
     * Get the user that owns the rating.
     * (کاربری که این امتیاز را ثبت کرده است)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the recipe that the rating belongs to.
     * (دستور غذایی که این امتیاز برای آن ثبت شده است)
     */
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
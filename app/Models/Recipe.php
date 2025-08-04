<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Report;
use App\Scopes\ActiveUserRecipeScope;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
            'title', 'description', 'ingredients', 'image_path', 'user_id', 'category_id', 'is_active'
        ];
    /**
     * The attributes that should be cast.
     */
     protected $casts = [
            'is_active' => 'boolean',
           // 'ingredients' => 'array', // اگر ingredients را به صورت جیسون ذخیره می‌کنید
        ];

     protected static function booted()
        {
            static::addGlobalScope(new ActiveUserRecipeScope);
        }
    // =================================================================
    // Relationships
    // =================================================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followings
 * @property-read \Illuminate\Database\Eloquent\Collection|Recipe[] $recipes
 * @property-read bool $is_admin
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active', 'profile_image_path',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // --- Relationships ---

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    // --- Custom Methods & Accessors ---

    /**
     * بررسی می‌کند که آیا کاربر فعلی، کاربر دیگری را دنبال می‌کند یا خیر.
     */
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

    /**
     * Accessor برای بررسی نقش ادمین.
     * (اصلاح شد: این نسخه به حروف بزرگ/کوچک و فاصله‌های اضافی حساس نیست)
     */
    protected function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn () => strtolower(trim($this->role)) === 'admin',
        );
    }
}

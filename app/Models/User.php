<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
//    implements FilamentUser, HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'about_info',
        'login',
        'email',
        'password',
        'avatar_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'favorites');
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'user_id');
    }

    public function allergies(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'allergies');
    }

    // На кого подписан на пользователя
    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'subscriber_id', 'subscribed_to_id');
    }

    // Кто подписан на пользователя
    public function subscribedTo(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions', 'subscribed_to_id', 'subscriber_id');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return public_path($this->avatar_url);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->admin == true;
    }
}

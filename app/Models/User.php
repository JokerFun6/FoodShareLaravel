<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class User extends Authenticatable implements FilamentUser, HasAvatar, MustVerifyEmail
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
        'avatar_url',
        'verification_code',
        'is_verified'
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



    public function canAccessPanel(Panel $panel): bool
    {
        return $this->admin == true;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return asset('storage/'.$this->avatar_url);
    }
    public static function generateAvatar($seed = 'Ivan')
    {
        $url = "https://api.dicebear.com/8.x/adventurer/png";
        $params = [
            'seed' => $seed,
            'size' => 512,
            'radius' => 50,
            'scale' => 110,
            'skinColor' => 'f2d3b1,ecad80',
            'backgroundColor' => 'B6F63E'
        ];

        try {
            // Выполнение запроса к API
            $response = Http::get($url, $params);

            if ($response->successful()) {
                // Сохранение изображения
                $filename = 'public/users_data/' . $seed . '.png';
                Storage::put($filename, $response->body());

                Storage::url($filename);
                return Str::after( $filename,'public/');
            } else {
                return 'users_data/user.png';
            }
        } catch (\Exception $e) {
            // Возвращение дефолтной строки в случае ошибки
            return 'users_data/user.png';
        }
    }

}

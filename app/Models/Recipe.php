<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;


    public $table = 'recipes';
    protected $fillable = [
        'title',
        'slug_title',
        'description',
        'preparation_time',
        'amount_services',
        'complexity',
        'photo_url',
        'cost',
        'nationality_id',
        'is_publish',
        'user_id',
        'is_visible'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
    public function getRouteKeyName(): string
    {
        return 'slug_title';
    }
    public function user():  BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function nationality():  BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipe_tag');
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class, 'recipe_id');
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe')
            ->withPivot('value', 'measure', 'comment');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'recipe_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'recipe_id');
    }

    public function marks():HasMany
    {
        return $this->hasMany(Mark::class, 'recipe_id');
    }

    public function avgMark()
    {
        return Mark::query()->where('recipe_id', $this->id)->avg('mark');
    }

    static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);

        // Проверяем уникальность slug в базе данных
        $count = Recipe::where('slug_title', $slug)->count();

        // Если slug уже существует, добавляем к нему числовой суффикс
        $uniqueSlug = $slug;
        $suffix = 1;
        while ($count > 0) {
            $uniqueSlug = $slug . '-' . $suffix;
            $count = Recipe::where('slug_title', $uniqueSlug)->count();
            $suffix++;
        }

        return $uniqueSlug;
    }
}

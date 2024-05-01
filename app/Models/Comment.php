<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;


    public $table = 'comments';
    public $timestamps = false;
    protected $fillable = [
        'recipe_id',
        'user_id',
        'description',
        'photo_url'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function recipe():  BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function user():  BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

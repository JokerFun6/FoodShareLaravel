<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    use HasFactory;

    public $table = 'marks';
    public $timestamps = false;
    protected $fillable = [
        'recipe_id',
        'user_id',
        'mark'
    ];

    public function user():  BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipe():  BelongsTo
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    public $table = 'steps';
    public $timestamps = false;
    protected $fillable = [
        'recipe_id',
        'description',
        'photo_url'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public $table = 'favorites';
    public $timestamps = false;
    protected $fillable = [
        'recipe_id',
        'user_id',
    ];


}

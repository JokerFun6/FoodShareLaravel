<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    public $table = 'ingredient_recipe';
    public $timestamps = false;
    protected $fillable = [
        'recipe_id',
        'ingredient_id',
        'measure',
        'value',
        'comment'
    ];

}

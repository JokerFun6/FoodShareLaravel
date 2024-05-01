<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nationality extends Model
{
    use HasFactory;


    public $table = 'nationalities';
    public $timestamps = false;
    protected $fillable = [
        'title',
        'slug_title',
    ];


    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'nationality_id');
    }
}

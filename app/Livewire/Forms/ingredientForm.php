<?php

namespace App\Livewire\Forms;

use App\Models\Ingredient;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ingredientForm extends Form
{
    #[Validate('required|numeric')]

    public int $selectedIngredient;
    #[Validate('required|numeric')]
    public string $value;
    #[Validate('required|string')]
    public string $measure;
    #[Validate('nullable|string|max:255')]

    public string $comment;


}

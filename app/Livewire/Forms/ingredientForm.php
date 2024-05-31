<?php

namespace App\Livewire\Forms;

use App\Models\Ingredient;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ingredientForm extends Form
{
    #[Validate('required|numeric', as: 'Ингредиент')]
    public int $selectedIngredient;
    #[Validate('required|numeric', as: 'Значение')]
    public string $value;
    #[Validate('required|string', as: 'Мера')]
    public string $measure = "";
    #[Validate('nullable|string|max:255', 'Примечание')]
    public string $comment;


}

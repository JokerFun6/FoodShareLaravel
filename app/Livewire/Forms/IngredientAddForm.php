<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class IngredientAddForm extends Form
{
    #[Validate('required|string|unique:ingredients,title')]
    public string $title;
}

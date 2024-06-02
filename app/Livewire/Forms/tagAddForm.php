<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class tagAddForm extends Form
{
    #[Validate('required|string|unique:tags,title')]
    public string $title;

}

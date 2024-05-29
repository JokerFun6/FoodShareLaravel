<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class stepForm extends Form
{
    use WithFileUploads;

    #[Validate('required|min:10')]
    public string $description;
    #[Validate('nullable|image|max:1500|dimensions:min_width=800,min_height=450')]
    public $photo;
}

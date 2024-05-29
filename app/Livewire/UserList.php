<?php

namespace App\Livewire;

use Livewire\Component;

class UserList extends Component
{
    public $recipes;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function render()
    {
        return view('livewire.user-list');
    }
}

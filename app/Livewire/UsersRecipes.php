<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Component;
use Mary\Traits\Toast;

class UsersRecipes extends Component
{
    use Toast;

    public function deleteRecipe(int $id){
        Recipe::query()->find($id)->delete();
        $this->success('Рецепт удален');
    }

    public function render()
    {
        $recipes = auth()->user()->recipes;
        return view('livewire.users-recipes', ['recipes' => $recipes]);
    }
}

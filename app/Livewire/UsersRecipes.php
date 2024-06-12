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

    public function changeVisible(int $id){
        $recipe = Recipe::query()->find($id);
        $recipe->is_visible = $recipe->is_visible == 1 ? 0 : 1;
        $recipe->save();
        $this->info('Видимость изменена');
    }

    public function render()
    {
        $recipes = auth()->user()->recipes()->latest()->get();
        return view('livewire.users-recipes', ['recipes' => $recipes]);
    }
}

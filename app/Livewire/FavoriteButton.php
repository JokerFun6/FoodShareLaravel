<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Component;
use Mary\Traits\Toast;

class FavoriteButton extends Component
{
    use Toast;

    public Recipe $recipe;
    public function toggle(){
        if(auth()->check()){
            $user = auth()->user();
            if($user->favorites->contains($this->recipe)){
                $user->favorites()->detach($this->recipe);
                return $this->success('Рецепт успешно удален из избранного');
            }
            else{
                $user->favorites()->attach($this->recipe);
                return $this->success('Рецепт добавлен в избранное');
            }
        }
        else{
            return $this->warning('Необходимо авторизоваться');
        }
        $this->recipe->refresh();
    }
    public function render()
    {
        return view('livewire.favorite-button');
    }
}

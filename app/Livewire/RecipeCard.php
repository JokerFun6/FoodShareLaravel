<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Component;
use Mary\Traits\Toast;

class RecipeCard extends Component
{
    use Toast;

    public Recipe $recipe;
    public function toggle(){
        if(auth()->check()){
            $user = auth()->user();
            if($user->favorites->contains($this->recipe)){
                $user->favorites()->detach($this->recipe);
                $this->success('Удален из избранного');
            }
            else{
                $user->favorites()->attach($this->recipe);
                $this->success('Добавлен в избранное');
            }
        }
        else{
            $this->info(
                title: 'Сообщение',
                description: 'Войдите в систему',
                position: 'bottom-end',

            );
//            return redirect()->route('login');
        }
        $this->recipe->refresh();
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.card-skeleton', $params);
    }

    public function render()
    {
        return view('livewire.recipe-card');
    }
}

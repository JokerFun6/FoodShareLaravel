<?php

namespace App\Livewire;

use App\Models\Mark;
use App\Models\Recipe;
use Livewire\Component;
use Mary\Traits\Toast;

class RatingForm extends Component
{
    use Toast;

    public Recipe $recipe;
    public int $mark = 5;

    public function createMark()
    {
        if(auth()->check()){
            $user = auth()->user();

            Mark::query()->updateOrCreate([
                'user_id'=>$user->id,
                'recipe_id'=>$this->recipe->id,
            ],[
                'user_id'=>$user->id,
                'recipe_id'=>$this->recipe->id,
                'mark'=>$this->mark,
            ]);
            return $this->success('Рецепт успешно оценен');

        }
        else{
            return $this->warning('Необходимо авторизоваться');
        }
        $this->recipe->refresh();
    }
    public function render()
    {
        return view('livewire.rating-form');
    }
}

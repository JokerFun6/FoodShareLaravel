<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Attributes\Url;
use Livewire\Component;

class SearchForm extends Component
{
    #[Url]
    public string $query = "";
    public bool $showdiv = false;

    public $records;

    public function searchRecipe()
    {
        return redirect()->route('recipes.index', ['query' => $this->query]);
    }
    public function hideResults()
    {
        $this->showdiv = false;
    }

    public function updatedQuery(){

        if(!empty($this->query)){

            $this->records = Recipe::query()->orderBy('title','asc')
                ->select('*')
                ->where('title','like','%'.$this->query.'%')
                ->where('is_publish', true)
                ->limit(5)
                ->get();

            $this->showdiv = true;
        }else{
            $this->showdiv = false;
        }
        $this->dispatch('update-query', query: $this->query)->to(RecipesList::class);
    }
    public function render()
    {
        return view('livewire.search-form');
    }
}

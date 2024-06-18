<?php

namespace App\Livewire;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RecipesList extends Component
{
    use WithPagination;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    #[Url]
    public string $query = '';
    #[Url]
    public string $level = '';
    #[Url]
    public string $min_price = '';
    #[Url]
    public string $max_price = '';

    #[Url]
    public string $min_time = '';
    #[Url]
    public string $max_time = '';
    #[Url]
    public bool $is_allergy = false;
    public bool $showFavorites = false;
    #[Url('tags')]
    public array $selectedTags = [];
    public array $selectedIngredients = [];

    public function resetProperties()
    {
        $this->reset();
    }

    #[On('update-query')]
    public function changeQuery($query){
        $this->query = $query;
    }

    public function changeDirection()
    {
        $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
    }
    #[Computed]
    public function tags()
    {
        return Tag::orderBy('title')->get();
    }
    #[Computed]
    public function ingredients()
    {
        return Ingredient::orderBy('title')->get();
    }

    public function render()
    {
        $allergies = auth()->user()?->allergies->pluck('id');

        $recipes = Recipe::query()
            ->where('is_publish', true)
            ->where('is_visible', true)
            ->when($this->query, fn(Builder $query)=> $query->where('title', 'like', '%' . $this->query . '%'))
            ->when($this->level, fn(Builder $query) => $query->where('complexity', $this->level))
            ->when($this->min_price, fn(Builder $query) => $query->where('cost', '>', $this->min_price))
            ->when($this->max_price, fn(Builder $query) => $query->where('cost', '<', $this->max_price))
            ->when($this->min_time, fn(Builder $query) => $query->where('preparation_time', '>', $this->min_time))
            ->when($this->max_time, fn(Builder $query) => $query->where('preparation_time', '<', $this->max_time))
            ->when($this->is_allergy, fn(Builder $query) => $query->whereDoesntHave('ingredients', fn(Builder $query) => $query->whereIn('ingredient_id', $allergies)))
            ->when($this->selectedTags, fn(Builder $query) => $query->whereHas('tags', fn(Builder $query) => $query->whereIn('tag_id', $this->selectedTags)))
            ->when($this->selectedIngredients, fn(Builder $query) => $query->whereHas('ingredients', fn(Builder $query) => $query->whereIn('ingredient_id', $this->selectedIngredients)))
            ->when($this->showFavorites, fn(Builder $query) => $query->whereIn('id', auth()->user()->favorites()->pluck('recipes.id')))
            ->with('ingredients')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(9);

        return view('livewire.recipes-list', [
            'recipes' => $recipes,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class RecipesList extends Component
{
    use WithPagination, WithoutUrlPagination;

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
    public bool $is_allergy = false;
    public bool $showFavorites = false;
    public array $selectedTags = [];
    public array $selectedIngredients = [];

    public function resetProperties()
    {
        $this->reset();
    }
    public function changeDirection()
    {
        $this->sortDirection = $this->sortDirection === 'desc' ? 'asc' : 'desc';
    }

    public function render()
    {
        $allergies = auth()->user()?->allergies->pluck('id');
        $tags = Tag::query()->orderBy('title')->get();
        $ingredients = Ingredient::query()->orderBy('title')->get();
        $recipes = Recipe::query()
            ->where('is_publish', true)
            ->where('title','like','%'.$this->query.'%')
            ->when($this->level, function (Builder $query){
                $query->where('complexity', '=', $this->level);
            })
            ->when($this->min_price, function (Builder $query){
                $query->where('cost', '>', $this->min_price);
            })
            ->when($this->max_price, function (Builder $query){
                $query->where('cost', '<', $this->max_price);
            })
            ->when($this->is_allergy, function (Builder $query) use($allergies){
                $query->whereDoesntHave('ingredients', function (Builder $query) use ($allergies) {
                    $query->whereIn('ingredient_id', $allergies);
                });
            })
            ->when($this->selectedTags, function (Builder $query){
                $query->whereHas('tags', function (Builder $query){
                    $query->whereIn('tag_id', $this->selectedTags);
                });
            })
            ->when($this->selectedIngredients, function (Builder $query){
                $query->whereHas('ingredients', function (Builder $query){
                    $query->whereIn('ingredient_id', $this->selectedIngredients);
                });
            })
            ->when($this->showFavorites, function (Builder $query) {
                $query->whereIn('id', auth()->user()->favorites()->pluck('recipes.id'));
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(9);

        return view('livewire.recipes-list', [
            'recipes' => $recipes,
            'tags' => $tags,
            'ingredients' => $ingredients
        ]);
    }
}

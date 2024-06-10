<?php

namespace App\Livewire\Forms;

use App\Models\Recipe;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Attributes\Validate;
use Livewire\Form;

class recipeForm extends Form
{
    public Recipe $recipe;
    #[Validate('nullable', as: 'Фото')]
    #[Validate('image', as: 'Фото', message: 'Прикрепляемый файл должен быть изображением')]
    #[Validate('dimensions:min_width=800,min_height=450', as: 'Фото', message: 'Изображение должно быть не меньше 800 * 450 px')]
    #[Validate('max:1500', as: 'Фото', message: 'Размер изображения не должен превышать 1500 кб')]
    public $recipe_photo;

    #[Validate('required|string|max:255|min:5', as: 'Название')]
    public string $recipe_title;
    #[Validate('required|string|min:20', as: 'Описание')]
    public string $recipe_description;
    #[Validate('required|numeric|min:1', as: 'Время приготовления')]
    public string $preparation_time;
    #[Validate('required|numeric|min:1|max:100', as: 'Количество порций')]
    public string $amount_services;
    #[Validate('required|string', as: 'Уровень сложности')]
    public string $recipe_level;
    #[Validate('required|numeric|min:10|max:12000', as: 'Стоимость')]
    public string $recipe_cost;
    #[Validate('required|numeric|min:1', as: 'Национальность', message: 'Выберите национальность блюда')]
    public $nation_id;
    public array $selectedTags;

    public string $photo_url = '';

    public function save_recipe(){

        $this->validate();

    }


}

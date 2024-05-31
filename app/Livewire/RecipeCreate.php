<?php

namespace App\Livewire;

use App\Http\services\ImageGenerator;
use App\Livewire\Forms\IngredientAddForm;
use App\Livewire\Forms\ingredientForm;
use App\Livewire\Forms\recipeForm;
use App\Livewire\Forms\stepForm;
use App\Livewire\Forms\tagAddForm;
use App\Models\Ingredient;
use App\Models\Nationality;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
use Mary\View\Components\Tags;

class RecipeCreate extends Component
{
    use WithFileUploads, Toast;
    public int $ingredientFormIndex = 0;
    public int $stepFormIndex = 0;
    public array $ingredients_data = [];
    public array $steps_data = [];
    public bool $modal = false;
    public recipeForm $recipe_form;
    public tagAddForm $tag_add_form;
    public ingredientAddForm $ingredient_add_form;
    public ?Recipe $recipe;
    public ingredientForm $ingredient_form;
    public stepForm $step_form;
    public $is_edit = false;
    #[Url]
    public int $stage = 1;

    public function mount($recipe = null){

        if($recipe != null){
            $this->recipe = $recipe;
            $this->recipe_form->recipe_title = $recipe->title;
            $this->recipe_form->recipe_description = $recipe->description;
            $this->recipe_form->recipe_cost = $recipe->cost;
            $this->recipe_form->recipe_level = $recipe->complexity;
            $this->recipe_form->amount_services = $recipe->amount_services;
            $this->recipe_form->preparation_time = $recipe->preparation_time;
            $this->recipe_form->nation_id = $recipe->nationality_id;
            $this->recipe_form->photo_url = 'storage/' . $recipe->photo_url;
            $this->recipe_form->selectedTags = $recipe->tags()->pluck('tags.id')->toArray();

            foreach ($recipe->ingredients as $index => $ingredient){
                $this->ingredients_data[$index]['title'] = $ingredient->title;
                $this->ingredients_data[$index]['selectedIngredient'] = $ingredient->id;
                $this->ingredients_data[$index]['value'] = $ingredient->pivot->value;
                $this->ingredients_data[$index]['measure'] = $ingredient->pivot->measure;
                $this->ingredients_data[$index]['comment'] = $ingredient->pivot->comment;
                $this->ingredientFormIndex++;
            }
            foreach ($recipe->steps as $index => $step){
                $this->steps_data[$index]['id'] = $step->id;
                $this->steps_data[$index]['description'] = $step->description;
                $this->steps_data[$index]['photo_url'] = $step->photo_url ? 'storage/' . $step->photo_url : '';
                $this->stepFormIndex++;
            }
            $this->is_edit = true;
        }

    }
    public function clearPhoto(){
        $this->recipe_form->reset('recipe_photo');
    }

    public function setStage($stage)
    {
        if ($this->is_edit) {
            $this->stage = $stage;
        }else{
            return $this->info('Сначало заполните все данные');
        }
    }

    public function save_recipe(){
        $this->recipe_form->validate();
        $this->stage++;
    }
    public function save_ingredients()
    {
        $this->validate(['ingredients_data' => 'required|min:1'], ['required' => 'Добавьте хотя бы один ингредиент']);
        $this->success('Ингредиенты успешно добавлены');
        $this->stage++;
    }
    public function addIngredient()
    {

        $data = $this->ingredient_form->validate();
        $this->ingredients_data[$this->ingredientFormIndex] = [
            'value' => $data['value'],
            'selectedIngredient' => $data['selectedIngredient'],
            'measure' => $data['measure'],
            'comment' => $data['comment'],
            'title' => Ingredient::query()->find($data['selectedIngredient'])['title'],
        ];
        $this->ingredientFormIndex++;
//        dd($this->ingredients_data[$this->ingredientFormIndex]);
    }
    public function removeIngredient($index)
    {
        unset($this->ingredients_data[$index]);
        $this->ingredients_data = array_values($this->ingredients_data);
        $this->ingredientFormIndex = count($this->ingredients_data);
//        dd($this->ingredients_data);
    }

    public function addStep()
    {
        $data = $this->step_form->validate();
        $this->steps_data[$this->stepFormIndex] = [
            'description' => $data['description'],
            'photo' => $data['photo'],
        ];
        $this->stepFormIndex++;
    }

    public function removeStep($index)
    {

        unset($this->steps_data[$index]);
        $this->steps_data = array_values($this->steps_data);
        $this->stepFormIndex = count($this->steps_data);
//        dd($this->ingredients_data);
    }
    public function save_steps()
    {
        $this->validate(['steps_data' => 'required|min:1'], ['required' => 'Добавьте хотя бы один шаг']);
        $this->success('Шаги успешно добавлены');
        $this->stage++;
        $this->is_edit = true;
    }
    public function add_tag(){
        $data = $this->tag_add_form->validate();
        $data['slug_title'] = Str::slug($this->tag_add_form->title);
        $id = Tag::query()->create($data);
        array_push($this->recipe_form->selectedTags, $id->id);
        return $this->info('Категория создана');
//        $this->tag_add_form->reset('title');
    }

    public function add_new_ingredient(){
        $data = $this->ingredient_add_form->validate();
        $data['slug_title'] = Str::slug($this->ingredient_add_form->title);
        $data['calorie'] = 0;
        $data['fats'] = 0;
        $data['protein'] = 0;
        $data['carbohydrates'] = 0;
        $id = Ingredient::query()->create($data);
        $this->ingredient_form->selectedIngredient = $id->id;
        return $this->info('Ингредиент создана');
//        $this->tag_add_form->reset('title');
    }

    public function complete(){
//        recipe add
        $resizedImagePath = null;
        if ($this->recipe_form->recipe_photo){
            $image = Image::read($this->recipe_form->recipe_photo);
            $resizedImage = $image->cover(800, 450);
            $resizedImagePath = public_path('storage\\recipes_data\\'.Str::uuid().'.jpg');
//            dd(Str::after($resizedImagePath, '\\storage\\'));
            $resizedImage->save($resizedImagePath);
            $resizedImage = Str::after($resizedImagePath, '\\storage\\');
        }else{
            // Использование
            $api = new ImageGenerator('https://api-key.fusionbrain.ai/', config('app.api_key'), config('app.api_secret_key'));
            $modelId = $api->getModel();
            $uuid = $api->generate(
                "Создайте изображение, которое иллюстрирует рецепт: [" . $this->recipe_form->recipe_title . "] Описание рецепта:" . $this->recipe_form->recipe_description . "Изображение должно быть аппетитным и привлекательным, представлять собой блюдо, которое можно приготовить по данному рецепту. Используйте яркие и качественные цвета, чтобы привлечь внимание посетителей сайта. Фон изображения должен быть нейтральным и не отвлекать внимание от блюда. Постарайтесь передать атмосферу и вкус блюда, чтобы заинтересовать пользователей и побудить их попробовать приготовить его сами.",
                $modelId
            );
            $images = $api->checkGeneration($uuid);
            if ($images !== null){
                $imageData = base64_decode($images[0]);
                $resizedImagePath = 'public/recipes_data/' . Str::uuid().'.jpg';
                Storage::write($resizedImagePath, $imageData);
                $resizedImagePath = Str::after($resizedImagePath, 'public/');
            }

        }
        if (isset($this->recipe) && $this->recipe->exists) {
            // Update existing recipe
            $this->recipe->update([
                'title' => $this->recipe_form->recipe_title,
                'description' => $this->recipe_form->recipe_description,
                'preparation_time' => $this->recipe_form->preparation_time,
                'amount_services' => $this->recipe_form->amount_services,
                'cost' => $this->recipe_form->recipe_cost,
                'complexity' => $this->recipe_form->recipe_level,
                'nationality_id' => $this->recipe_form->nation_id,
                'photo_url' => $resizedImagePath ? $resizedImagePath : $this->recipe->photo_url,
                'user_id' => auth()->user()->id,
            ]);
        } else {
            // Create new recipe
            $this->recipe = Recipe::query()->create([
                'title' => $this->recipe_form->recipe_title,
                'slug_title' => Recipe::generateUniqueSlug($this->recipe_form->recipe_title),
                'description' => $this->recipe_form->recipe_description,
                'preparation_time' => $this->recipe_form->preparation_time,
                'amount_services' => $this->recipe_form->amount_services,
                'cost' => $this->recipe_form->recipe_cost,
                'complexity' => $this->recipe_form->recipe_level,
                'nationality_id' => $this->recipe_form->nation_id,
                'photo_url' => $resizedImagePath ? $resizedImagePath : 'recipes_data/recipe_photo_default.png',
                'user_id' => auth()->user()->id,
            ]);
        }
        $this->recipe->tags()->sync($this->recipe_form->selectedTags);

        // Sync ingredients
        $ingredientData = [];
        foreach ($this->ingredients_data as $item) {
            $ingredientData[$item['selectedIngredient']] = [
                'value' => $item['value'],
                'measure' => $item['measure'],
                'comment' => $item['comment']
            ];
        }
        $this->recipe->ingredients()->sync($ingredientData);
        // Handle steps
        $existingStepIds = $this->recipe->steps->pluck('id')->toArray();
        $newStepIds = [];

        foreach ($this->steps_data as $item) {
            $url = null;
            if (isset($item['photo']) && $item['photo']) {
                $imagePath = $item['photo']->store('public/steps');
                $url = Str::after($imagePath, 'public/');
            }

            $step = $this->recipe->steps()->updateOrCreate(
                ['id' => $item['id'] ?? null], // Check if step exists by id
                [
                    'description' => $item['description'],
                    'photo_url' => $url,
                ]
            );

            $newStepIds[] = $step->id;
        }

        // Delete steps that are not in the new list
        $stepsToDelete = array_diff($existingStepIds, $newStepIds);
        $this->recipe->steps()->whereIn('id', $stepsToDelete)->delete();

        $this->success('Рецепт отправлен на модерацию',timeout: 5000,  redirectTo: route('users.index'), );

    }

    public function render()
    {
        $nationalities = Nationality::query()->orderBy('title')->get();
        $tags = Tag::query()->orderBy('title')->get();
        $ingredients  = Ingredient::query()->orderBy('title')->get();
        return view('livewire.recipe-form',[
            'nationalities' => $nationalities,
            'tags' => $tags,
            'ingredients' => $ingredients,
        ]
        );
    }
}

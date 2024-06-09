<?php

namespace App\Livewire;

use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class ProfileUpdate extends Component
{
    use Toast;
    use WithFileUploads;

    #[Validate('nullable|image|max:5000', message: ['max' => 'Размер изображения не должен превышать 5000 кб'])]
    public $avatar;
    #[Validate('nullable|string')]
    public $name;
    #[Validate('nullable|string')]
    public $last_name;
    public array $selectedIngredients;
    public int $stage_avatar = 0;

//    public $ingredients;
    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->last_name = $user->lastname;
        $this->selectedIngredients = auth()->user()->allergies()->pluck('ingredients.id')->toArray();
//        dd($this->selectedIngredients);
    }
    public function save()
    {
        $this->validate();
        $user = auth()->user();
        User::query()->find($user->id)->update([
            'name' => $this->name,
            'lastname' => $this->last_name
        ]);
        $res = $user->allergies()->sync($this->selectedIngredients);

        return $this->success('Ваши данные были успешно изменены');
    }

    public function updatedAvatar($value)
    {
        $this->stage_avatar++;
        if($this->stage_avatar === 2){
            $this->validateOnly('avatar');
            $user = auth()->user();
            if ($user->photo_url != 'users_data/user.png') {
                Storage::delete('public/' . $user->avatar_url);
            }
            dd($this->avatar);
            $imagePath = $this->avatar->store('public/users_data');
            $imagePath = Str::after($imagePath, 'public/');
            User::query()->find( $user->id)->update([
                'avatar_url' => $imagePath,
            ]);
            $this->stage_avatar = 0;
            return $this->success('Аватар был успешно изменен');
        }
        $this->reset('avatar');
    }
    public function render()
    {
        $ingredients = Ingredient::query()->orderBy('title')->get();
        return view('livewire.profile-update')->with('ingredients', $ingredients);
    }
}

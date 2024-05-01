<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class LoginForm extends Component
{
    use Toast;
    #[Validate(['required','exists:users'], as: 'Почта')]
    public string $email;
    #[Validate(['required'], as: 'Пароль')]
    public string $password;
    public bool $remember = false;


    public function login(){
        $data = $this->validate();
        if (Auth::attempt($data, $this->remember)){
            request()->session()->regenerate();
            return $this->success('Вы успешно вошли в систему', redirectTo: 'recipes/topic');
//                redirect()
//                ->route('recipes.index')
//                ->with(['msg'=>'Вы успешно авторизованы в системе🍻']);
        }
        return $this->error('Данные введены некорректно');
    }
    public function render()
    {
        return view('livewire.login-form');
    }
}

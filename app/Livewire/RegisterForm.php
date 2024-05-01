<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class RegisterForm extends Component
{
    use Toast;

    #[Validate(['required','string','unique:users'], as: 'Логин')]
    public string $login;

    #[Validate(['required','email','unique:users'], as: 'Почта')]
    public string $email;

    #[Validate(['required', 'min:8', 'confirmed'], as: 'Пароль')]
    public string $password;
    #[Validate(['required'], as: 'Подтверждение пароля')]
    public string $password_confirmation;
    #[Validate(['required', 'accepted'], as: 'Согласие')]
    public string $agree;

    public function register(){
        $data = $this->validate();
        $user = User::query()->create($data);
        return $this->success('Ваш аккаунт успешно создан🎂!', redirectTo: 'login');
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}

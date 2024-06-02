<?php

namespace App\Livewire;

use App\Models\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    public function login()
    {
        $data = $this->validate();

        if (Auth::attempt($data, $this->remember)) {
            $user = Auth::user();

            if ($user->is_verified) {
                request()->session()->regenerate();
                return $this->success('Вы успешно вошли в систему', redirectTo: 'recipes/topic');
            } else {
                session()->put('user_id', $user->id);
                $verificationCode = random_int(1000, 9999);
                session()->put('verify_code', $verificationCode);
                Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
                Auth::logout();
                return $this->error('Подтвердите почту', redirectTo: 'verify-email');
            }
        }

        return $this->error('Данные введены некорректно');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}

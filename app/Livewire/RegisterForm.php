<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\VerificationCodeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
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
        $data['avatar_url'] = User::generateAvatar($this->login);
        // Generate a 4-digit verification code
        $verificationCode = random_int(1000, 9999);

        // Create user with additional verification code and status
        $user = User::query()->create(array_merge($data, [
            'verification_code' => $verificationCode,
            'is_verified' => false,
        ]));

        // Send verification email
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
        session()->put('verify_code', $verificationCode);
        session()->put('user_id', $user->id);
        return redirect()->route('verification.notice');
//        return $this->success('Ваш аккаунт успешно создан🎂!', redirectTo: 'login');
    }

    public function render()
    {
        return view('livewire.register-form');
    }
}

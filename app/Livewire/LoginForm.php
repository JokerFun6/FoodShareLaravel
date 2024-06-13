<?php

namespace App\Livewire;

use App\Models\ResetPasswordMail;
use App\Models\User;
use App\Models\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class LoginForm extends Component
{
    use Toast;
    #[Validate(['required'], as: 'Почта или Логин')]
    public string $email;
    #[Validate(['required'], as: 'Пароль')]
    public string $password;
    #[Validate('nullable|email|exists:users,email', as: 'почта восстановления')]
    public string $reset_email;
    public bool $remember = false;

    public function login()
    {
        $data['email'] = $this->validateOnly('email');
        $data['password'] = $this->validateOnly('password');
        $fieldType = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        if (Auth::attempt([$fieldType => $this->email, 'password' => $this->password], $this->remember)) {
            $user = Auth::user();
            if ($user->ban) {
                Auth::logout();
                return $this->error('Ваш аккаунт заблокирован по причине "' . $user->reason_ban . '"', timeout: 6000);
            }
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

    public function reset_password(){
        $this->validateOnly('reset_email');
        $user = User::query()->where('email', $this->reset_email)->firstOrFail();
        $new_password = Str::random(8);
        $user->password = $new_password;
        $user->save();
        Mail::to($user->email)->send(new ResetPasswordMail($new_password));
        $this->info('Новый пароль отправлен на почту');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}

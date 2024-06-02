<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class VerifyCode extends Component
{
    use Toast;

    public string $code = '';

    public function verify()
    {
        $verify_code = session()->get('verify_code');
        $user_id = session()->get('user_id');
        if ($verify_code == $this->code) {
            $user = User::query()->find($user_id)->update(['is_verified' => true, 'verification_code' => null]);
            session()->forget(['verify_code', 'user_id']);
            return $this->success('Аккаунт подтвержден', redirectTo: 'login');
        }

        return $this->addError('code', 'Неверный код');
    }

    public function resend_message(){

        $verificationCode = random_int(1000, 9999);
        session()->forget('verify_code');
        session()->put('verify_code', $verificationCode);
        $user_id = session()->get('user_id');

        $user = User::query()->find($user_id);
        // Send verification email
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));
        return $this->info('Код отправлен заново');

    }

    public function render()
    {
        return view('livewire.verify-code');
    }
}


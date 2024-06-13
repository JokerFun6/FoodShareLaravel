<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $new_password;

    public function __construct($new_password)
    {
        $this->new_password = $new_password;
    }

    public function build()
    {
        return $this->subject('Ваш новый пароль')
            ->view('emails.reset_password')
            ->with('new_password', $this->new_password);
    }
}

<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use SerializesModels;

    public $user;
    public $otp;

    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->view('auth.otp')
                    ->with([
                        'user' => $this->user,
                        'otp' => $this->otp,
                    ])
                    ->subject('Your OTP Code');
    }
}

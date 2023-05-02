<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPGenerated extends Mailable
{
    use Queueable, SerializesModels;

    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function build()
    {
        return $this->view('mail.otp', ['code' => $this->code])->subject('Your Verification Code');
    }
}

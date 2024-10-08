<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }
    public function build()
    {
        return $this->view('emails.verify')
                    ->with([
                        'url' => url("/verify-email?token={$this->token}"),
                    ]);
    }
}

<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    public function __construct($code)
    {
        $this->code = $code; // This will now be the 6-digit code
    }

    public function build()
    {
        return $this->subject('Password Reset Code')
                    ->view('email.forgetPassword') // Ensure this points to the correct template
                    ->with(['code' => $this->code]);
    }
}
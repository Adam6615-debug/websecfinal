<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $newPassword;

    public function __construct($name, $newPassword)
    {
        $this->name = $name;
        $this->newPassword = $newPassword;
    }

    public function build()
    {
        return $this->subject('Your New Password for Opium')
            ->view('email.reset_password')
            ->with([
                'name' => $this->name,
                'newPassword' => $this->newPassword,
            ]);
    }
}

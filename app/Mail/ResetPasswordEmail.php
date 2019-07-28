<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetPassword;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->resetPassword = [
            'first_name' => $emailData['first_name'],
            'link' => url('password/' . $emailData['link'] ) . '/' . $emailData['token'],
            'msg' => $emailData['msg']
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.resetPassword')->subject('איפוס סיסמה באמצעות אימייל');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddBpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($emailData)
    {
        $this->data = [
            'firstName' => $emailData['firstName'],
            'newUserName' => $emailData['newUserName']
        ];
    }

    public function build()
    {
        return $this->view('emails.addbp');
    }
}

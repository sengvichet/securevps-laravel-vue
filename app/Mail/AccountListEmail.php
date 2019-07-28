<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountListEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $accountlist;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->accountlist = [
            'first_name' => $emailData['first_name'],
            'link' => url('login/accountlistbyemail') . '/' . $emailData['token']
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.accountlist');
    }
}

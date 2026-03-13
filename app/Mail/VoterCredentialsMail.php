<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VoterCredentialsMail extends Mailable
{
    public $name;
    public $email;
    public $password;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Voting System Login Details')
            ->view('emails.voter_credentials');
    }
}
<?php

// app/Mail/ContactUsMessage.php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMessage extends Mailable
{
    use SerializesModels;

    public $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject('Contact Us: ' . $this->contact->subject)
                    ->view('emails.contact');
    }
}

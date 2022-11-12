<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportContactSendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $nombres;
    public $email;
    public $apellidos; 
    public $asunto;
    public $pathToImage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$apellidos,$nombres,$asunto)
    {
        $this->nombres = $nombres;
        $this->email = $email; 
        $this->apellidos= $apellidos;
        $this->asunto=$asunto;
        $this->pathToImage="./assets/images/logo-system.png";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact');
    }
}

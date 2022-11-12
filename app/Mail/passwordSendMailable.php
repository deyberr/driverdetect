<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class passwordSendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $subject; 
    public $tempassword;
    public $pathToImage;
    /**
     * Create a new message instance.
     *
     * @return void
     */
 

    public function __construct($email, $name, $tempassword,$subject)
    {
        $this->name = $name;
        $this->email = $email; 
        $this->tempassword=  $tempassword;
        $this->subject=$subject;
        $this->pathToImage="./assets/images/logo-system.png";
    }




    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      

        return  $this->view('emails.credentials'); 
         
            
    }
}

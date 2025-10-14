<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $attachmentPath;

    /**
     * Create a new message instance.
     */
    public function __construct($details, $attachmentPath = null)
    {
        
      $this->details = $details;
      $this->attachmentPath = $attachmentPath;


    }


   public function build(){
    
    $email = $this->subject($this->details['subject'])
                  ->view('teacher.testmail')
                  ->with('details', $this->details);

        if ($this->attachmentPath) {
            
            $email->attach($this->attachmentPath);
        }          

    return $email;
   }



    /**
     * Get the message envelope.
     */
   
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookClassTeacher extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //error_log(json_encode($this->data));
        $date = date("g:i a", strtotime($this->data->schedule));
        return $this->view('emails.book_class_teacher', compact($this->data))->subject("You have a class at $date today");
    }
    
}

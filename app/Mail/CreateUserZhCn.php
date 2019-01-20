<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserZhCn extends Mailable implements ShouldQueue
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
        return $this->view('emails.create_user_zh_cn', compact($this->data))->subject("[欢言英语]邀您开启英语学习之旅。");
    }
    
}

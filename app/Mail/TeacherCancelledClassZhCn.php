<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeacherCancelledClassZhCn extends Mailable implements ShouldQueue
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
        return $this->view('emails.teacher_cancelled_class_zh_cn', compact($this->data))->subject("[欢言英语] 非常抱歉，外教取消了预约课程。");
    }
    
}

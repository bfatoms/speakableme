<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookClass;
use App\Mail\BookClassTeacher;
use App\Mail\BookClassStudent;
use App\Mail\BookClassStudentZhCn;
use App\Mail\CreateUser;
use App\Mail\CreateUserZhCn;
use App\Mail\LessonMemo;
use App\Mail\ReferredStudent;
use App\Mail\TeacherCancelledClass;
use App\Mail\TeacherCancelledClassZhCn;
use App\Mail\StudentCancelledClass;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email;
    public $type;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $type, $data)
    {
        $this->email = $email;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //error_log(json_encode($this->data));
        if($this->type == "create_user") {
            Mail::to($this->email)->send(new CreateUser($this->data));
        }
        else if($this->type == "create_user_zh_cn") {
            Mail::to($this->email)->send(new CreateUserZhCn($this->data));
        }
        else if($this->type == "book_class") {
            Mail::to($this->email)->send(new BookClass($this->data));
        }
        else if($this->type == "book_class_teacher") {
            Mail::to($this->email)->send(new BookClassTeacher($this->data));
        }
        else if($this->type == "book_class_student") {
            Mail::to($this->email)->send(new BookClassStudent($this->data));
        }
        else if($this->type == "book_class_student_zh_cn") {
            Mail::to($this->email)->send(new BookClassStudentZhCn($this->data));
        }
        else if($this->type == "student_cancelled_class") {
            Mail::to($this->email)->send(new StudentCancelledClass($this->data));
        }
        else if($this->type == "teacher_cancelled_class") {
            Mail::to($this->email)->send(new TeacherCancelledClass($this->data));
        }
        else if($this->type == "teacher_cancelled_class_zh_cn") {
            Mail::to($this->email)->send(new TeacherCancelledClassZhCn($this->data));
        }
        else if($this->type == "lesson_memo") {
            Mail::to($this->email)->send(new LessonMemo($this->data));
        }
        else if($this->type == "referred_student") {
            Mail::to($this->email)->send(new ReferredStudent($this->data));
        }
    }
}

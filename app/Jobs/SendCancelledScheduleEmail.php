<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\CancelledScheduleEmail;

class SendCancelledScheduleEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // logger(json_encode($this->email));
        try
        {
            \Mail::to($this->email)
                ->locale($this->data['student']->lang)
                ->send(new CancelledScheduleEmail($this->data));
        }
        catch(\Exception $ex)
        {

            logger(json_encode($ex));
        }
    }

    public function failed()
    {
        
    }
}

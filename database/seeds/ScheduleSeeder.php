<?php

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Support\Carbon;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher = Teacher::where('email','ggteacher@yopmail.com')->first();
        // $now = Carbon::parse(now()->format('Y-m-d\TH:00:00'));

        $starts_at = Carbon::parse(now()->format('Y-m-d\TH:00:00'));
            
        $ends_at = Carbon::parse(now()->format('Y-m-d\TH:00:00'))->addMinutes(25);

        //open a schedule 50 times
        for($i=0; $i<500; $i++)
        {
            $newStart = clone $starts_at;

            $newEnds = clone $ends_at;

            Schedule::create([
                'starts_at' => $newStart->format('Y-m-d\TH:i:s'),
                'ends_at' => $newEnds->format('Y-m-d\TH:i:s'),
                'user_id' => $teacher->id,
                'class_type_id' => 1,
                'class_session_id' => 2,
                'status' => 'open',
                'subject_id' => 1,
                'teacher_provider_id' => $teacher->entity_id,
                'min' => 1,
                'max' => 1
            ]);

            $starts_at = clone $starts_at->addMinutes('30');

            $ends_at = clone $ends_at->addMinutes('30');
        }
    }
}

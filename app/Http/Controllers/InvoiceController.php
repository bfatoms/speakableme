<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Entity;
use Illuminate\Support\Carbon;
use App\Models\ScheduleTeacherRate;
use App\Models\Teacher;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function store($current = null)
    {
        // generate invoice for current cut-off
        $current = $current ? currentCutOff() : getCutOff();
        // for all schedule, that is completed(no penalties), and cancelled (with penalties)
        $entities = Entity::where('managed_by_id', auth()->user()->entity_id)->get(['id']);

        $schedules = Schedule::whereIn('teacher_provider_id', $entities)
            ->whereIn('status', ['completed', 'cancelled'])
            ->whereBetween('starts_at', [$current['start'], $current['end']] )
            ->get();


        $teacher_ids = $schedules->pluck('user_id')->unique();

        $schedules = $schedules->groupBy('user_id');

        $invoices = [];

        foreach($teacher_ids as $teacher_id)
        {
            $schedule_teacher_rate = ScheduleTeacherRate::whereIn('schedule_id', $schedules[$teacher_id]->pluck('id'))
                ->whereNull('invoice_id')
                ->get();
            
            if($schedule_teacher_rate->isEmpty())
            {
                continue;
            }

            $teacher = Teacher::find($teacher_id);
            
            $entity = Entity::find($teacher->entity_id);
            
            $code = $entity->prefix . now()->format("Y") . "-" . now()->format("Hismd") . "-" . str_random(5);

            $fee = $schedule_teacher_rate->sum('fee');

            $penalty = $schedule_teacher_rate->sum('penalty');

            $incentive = $schedule_teacher_rate->sum('incentive');

            $invoice = Invoice::create([
                'code' => $code,
                'bank_name' => $teacher->bank_name,
                'bank_account_name' => $teacher->bank_account_name,
                'bank_account_number' => $teacher->bank_account_number,
                'teacher_id' => $teacher->id,
                'teacher_provider_id' => $entity->id,
                'entity_id' => auth()->user()->entity_id,
                'fee' => $fee,
                'penalty' => $penalty,
                'incentive' => $incentive,
                'total' => ($fee + $incentive) - $penalty,
                'cut_off_starts_at' => $current['start'],
                'cut_off_ends_at' => $current['end']
            ]);
            
            ScheduleTeacherRate::whereIn('schedule_id', $schedules[$teacher_id]->pluck('id'))
                ->update([
                    'invoice_id' => $invoice->id,
                ]);

            $invoices[] = $invoice;
        }

        return $this->respond($invoices);
    }

    public function previewInvoice($teacher_id)
    {
        // generate invoice for current cut-off
        $current = getCutOff();
        // for all schedule, that is completed(no penalties), and cancelled (with penalties)
        $entities = Entity::where('managed_by_id', auth()->user()->entity_id)->get(['id']);

        $schedules = Schedule::whereIn('teacher_provider_id', $entities)
            ->whereIn('status', ['completed', 'cancelled'])
            ->whereBetween('starts_at', [$current['start'], $current['end']] )
            ->get();


        $teacher_ids = $schedules->pluck('user_id')->unique();

        $schedules = $schedules->groupBy('user_id');

        $invoices = [];

        foreach($teacher_ids as $teacher_id)
        {
            $schedule_teacher_rate = ScheduleTeacherRate::whereIn('schedule_id', $schedules[$teacher_id]->pluck('id'))
                ->whereNull('invoice_id')
                ->get();
            
            if($schedule_teacher_rate->isEmpty())
            {
                continue;
            }

            $teacher = Teacher::find($teacher_id);
            
            $entity = Entity::find($teacher->entity_id);
            
            $code = $entity->prefix . now()->format("Y") . "-" . now()->format("Hismd") . "-" . str_random(5);

            $fee = $schedule_teacher_rate->sum('fee');

            $penalty = $schedule_teacher_rate->sum('penalty');

            $incentive = $schedule_teacher_rate->sum('incentive');

            $invoice = [
                'code' => $code,
                'bank_name' => $teacher->bank_name,
                'bank_account_name' => $teacher->bank_account_name,
                'bank_account_number' => $teacher->bank_account_number,
                'teacher_id' => $teacher->id,
                'teacher_provider_id' => $entity->id,
                'entity_id' => auth()->user()->entity_id,
                'fee' => $fee,
                'penalty' => $penalty,
                'incentive' => $incentive,
                'total' => ($fee + $incentive) - $penalty,
                'cut_off_starts_at' => $current['start'],
                'cut_off_ends_at' => $current['end']
            ];

            $invoices[] = $invoice;
        }

        return $this->respond($invoices);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'code',
        'paid_at',
        'status',
        'teacher_id',
        'teacher_provider_id',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'entity_id',
        'fee',
        'penalty',
        'total',
        'incentive',
        'cut_off_starts_at',
        'cut_off_ends_at'
    ];

    protected $dates = [
        'paid_id',
        'cut_off_starts_at',
        'cut_off_ends_at',
        'created_at',
        'updated_at'
    ];
}

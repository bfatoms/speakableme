<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "school_package_id",
        "student_id",
        "voucher_id",
        "order_number",
        "currency",
        "name",
        "status",
        "remaining_reservation",
        "duration",
        "base_price",
        "additional_price",
        "discount_price",
        // original_total_price
        "total_price",
    ];
}

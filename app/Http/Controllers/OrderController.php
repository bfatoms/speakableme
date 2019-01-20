<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;
use App\SchoolPackage;
use App\Order;
use App\Voucher;

class OrderController extends Controller
{

    public function index()
    {
        return Order::where('student_id', auth()->user()->id)->get();
    }

    public function store(Request $request)
    {

        $school = School::find(auth()->user()->school_id);
        $package = SchoolPackage::find($request->school_package_id);

        if($request->voucher_id != null || $request->voucher_id != "") {
            $voucher = Voucher::find($request->voucher_id);
            $voucher->quantity--;
            $voucher->save();
            // compute for new prices
        }

        $total_price = $package->price;
        if(!empty($request->voucher_id)) {
            /**TODO: voucher id re compute total price */
        }

        $order = Order::create([
            "school_package_id" => $package->id,
            "student_id"=>auth()->user()->id,
            "voucher_id" => $request->voucher_id,
            "order_number" => $school->prefix.rand(10,999).'-'.rand(100000, 999999),
            "currency" => "USD",
            "name" => $package->name,
            "status" => "pending",
            "remaining_reservation" => $package->number_of_classes,
            "duration" => $package->duration_in_days,
            "base_price" => $package->base_price,
            "additional_price" => $package->additional_price,
            "discount_price" => $request->discount_price,
            // original_total_price
            "total_price" => $total_price,
        ]);

        return $this->response("Order Successfully Created", $order);
    }
}

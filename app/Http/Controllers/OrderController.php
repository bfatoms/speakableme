<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\School;
// use App\SchoolPackage;
// use App\Voucher;
use App\Models\Order;
use App\Models\EntityPackage;
use App\Models\Voucher;
use App\Models\BalanceType;
use App\Models\Balance;

class OrderController extends Controller
{

    public function index()
    {
        return Order::where('user_id', auth()->user()->id)->get();
    }

    public function store()
    {
        $package = EntityPackage::find(request('package_id'));

        $voucher = Voucher::find(request('voucher_id'));

        $discount = 0;

        if(!empty($voucher))
        {
            $discount = $voucher->value;

            if(!$voucher->is_fixed)
            {
                $discount = $package->total * ($voucher->value/100);
            }
        }

        $code = auth()->user()->load('entity')->entity->prefix . 
            now()->format("Y") . "-" . now()->format("Hismd") . "-" . str_random(4);

        $create = [
            'class_type_id' => $package->class_type_id,
            'user_id' => request('user_id', auth()->user()->id),
            'code' => $code,
            'number_of_classes' => $package->number_of_classes,
            'duration_in_days' => $package->duration_in_days,
            'price' => $package->total,
            'discount_price' => $discount,
            'total_price' => ($package->total - $discount),
            'student_provider_id' => request('student_provider_id', auth()->user()->entity_id)
        ];
        
        $created = Order::create($create);

        return $this->respond($created, "Order Created");
    }

    public function approve($code)
    {
        // $this->authorize();
        // DO NOTE THAT APPROVED DOESN'T MEAN IT IS PAID, USE PAID_AT COLUMN TO SET AS PAID
        $order = Order::where('code', $code)
            ->where('status', 'pending')
            ->first();

        if(empty($order)){
            return $this->respond([], "Order is approved, or doesn't exist..", 404);
        }
        
        $updated = $order->update([
            'status' => 'approved',
            'approved_at' => now()
        ]);

        if($updated)
        {
            Balance::create([
                'user_id' => $order->user_id,
                'balance_type_id' => BalanceType::where('class_type_id', $order->class_type_id)
                    ->where('name', 'order')
                    ->first()->id,
                'remaining' => $order->number_of_classes,
                'total' => $order->number_of_classes,
                'validity' => now()->addDays($order->duration_in_days),
                'order_id' => $order->id
            ]);
        }

        return $this->respond($order->refresh(), "Order Successfully Approved!");
    }

    public function storeOld(Request $request)
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

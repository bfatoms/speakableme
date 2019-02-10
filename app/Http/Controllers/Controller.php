<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respond($result, $message="")
    {
        return response()->json([
            'success' => (\http_response_code() > 230) ? false:true,
            'message' => __($message),
            'result' => $result,
        ], \http_response_code());
    }
}

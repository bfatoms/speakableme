<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respond($result, $message="", $code=null)
    {
        $code = $code ?? http_response_code($code);

        return response()->json([
            'success' => ($code > 230) ? false:true,
            'message' => __($message),
            'result' => $result,
        ], $code);
    }
}

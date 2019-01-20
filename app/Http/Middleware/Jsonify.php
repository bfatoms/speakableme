<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;
use App\Helpers\Common;

class Jsonify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set("X-Requested-With","XMLHttpRequest");
        $response = $next($request);
        $successful = $response->isSuccessful();
        $exception = $response->exception ?? false;

        // handle thrown exception
        if($successful === false && $exception !== false) 
        {
            return $this->sendResponse(
                $exception->getCode(),
                false,
                $exception->getMessage(),
                ["file:"=> $exception->getFile(), "line" => $exception->getLine()]);
        }

        $code = $response->getStatusCode();        
        $content = json_decode($response->getContent());
        if(\json_last_error()){
            $content = [$response->getContent()];
        }
        // dd($response->getContent());
        // if _message is empty pass an empty string
        $message = $content->message ??  $response::$statusTexts[$code];        

        $data = $content->result ?? $content;

        return $this->sendResponse(
            $code,
            $successful,
            $message,
            $data);
    }


    public function sendResponse($code=500, $success=false, $message="", $data=[]){
        
        return response()->json(
            [
                "code"=> ($code != 0) ? $code : 500,
                "success"=> $success,
                "message"=> $message,
                "data"=> $data
            ],
            ($code != 0) ? $code : 500
        );
    }
}

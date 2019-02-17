<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if(debug()) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);    
        }

        $debug_code = str_random(18);

        Log::channel('dailyerr')->info([$debug_code => $exception->getMessage()]);

        return response()->json([
            'success' => false,
            'message' => 'Something Went Wrong, Contact The Site Administrator and send this code: '. $debug_code,
        ]);

    }
}

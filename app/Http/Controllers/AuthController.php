<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use PHPUnit\Framework\MockObject\Stub\Exception;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Student;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->roles = config('app.roles');
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            throw new \Exception("Unauthorized User", 401);
        }

        // if($this->roles[auth()->user()->role_id] != request('role')){
        //     throw new \Exception("Unauthorized User", 401);
        // }



        return $this->respondWithToken($token,"Logged in successfully!");
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // get user info
        $user = auth()->user();
        if(request('role') === "student"){
            $user = collect($user)->except(['bank_name',
            'bank_account_number',
            'peak1to15',
            'peak16to31',
            'password_changed',
            'special_plotting_indefinite',
            'teacher_account_type_id',
            'special_plotting',
            'bank_account_name',
            'settings',
            'password'
            ]);
        }

        return $this->response("OK", $user);   
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->invalidate();
        return $this->response("Successfuly Logged Out",[]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $message="")
    {
        return $this->response($message, [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
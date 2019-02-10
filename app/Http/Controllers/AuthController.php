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
        // $this->roles = config('app.roles');
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

        // get user class from system_name in roles

        // $user = $this->getUser();

        dd(auth()->user()->roles());

        return $this->respondWithToken($token, "Logged in successfully!");
    }

    public function getUser($class)
    {
        return $class::first(auth()->user());
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
        
        return $this->response($user, "OK");   
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
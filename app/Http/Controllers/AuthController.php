<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $this->middleware('auth:api', ['except' => ['login','forceChangePassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        // check if user can login
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            throw new \Exception("Unauthorized User", 401);
        }
   
        $data = array_merge(
            ["token" => $this->getToken($token) ],
            ["user" => $this->getUser()->toArray() ]
        );

        return $this->respond($data, "Logged in successfully!");
    }

    public function getUser()
    {
        // get current user role system name
        $role = Role::find(auth()->user()->role_id);
        switch($role->system_name){
            case 'student':
            case 'teacher':
                break;
            default:
            {
                $role->system_name = 'user';
                break;            
            } 
        }

        $reflect = new \ReflectionClass('App\Models\\' . ucfirst($role->system_name));
        $class = $reflect->newInstance();
        return $class::find(auth()->user()->id);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->respond($this->getUser(), "OK");   
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->invalidate();
        return $this->respond([],"Successfuly Logged Out");
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respond(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function forceChangePassword()
    {
        if(request('superadmin') == true){
            $email = request('email');
            $user = User::where('email', $email)->firstOrFail();
            $user->password = Hash::make(request('new_password'));
            $user->save();
            return $this->respond([],"SUCCESS_FORCE_PASSWORD_CHANGE");
        }

        return $this->respond([], "Unauthorized To Force Change Password", 401);
    }

}
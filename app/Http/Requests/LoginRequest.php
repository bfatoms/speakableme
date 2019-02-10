<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use App\Models\RolePermission;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::where('email',request('email'))->first();

        $role = (!empty(RolePermission::where('role_id', $user->role_id)
            ->whereIn('permission_id', ['login','do-all'])->first())) ? true:false;
        return $role;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}

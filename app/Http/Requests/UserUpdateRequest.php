<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.request()->route()->parameter('user'),
            //'random_password' => 'required|boolean',
            //'password' => 'exclude_if:role_id,'.Role::ROLE_PARTICIPANT.'|exclude_if:random_password,true|required|nullable|string|confirmed',
            'phone' => 'sometimes|string|nullable',
            'address' => 'sometimes|string|nullable',
            'state' => ['exclude_unless:role_id,'.Role::ROLE_PARTICIPANT,'required',Rule::in(User::STATES)],
            'role_id' => 'required|exists:roles,id',
            //Role is representative
            'representative' => 'exclude_unless:role_id,'.Role::ROLE_REPRESENTATIVE.'|sometimes|array',
            'representative.participants.*' => 'integer|exists:participants,user_id',
        ];
    }
}

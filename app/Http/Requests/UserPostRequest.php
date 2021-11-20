<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPostRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'random_password' => 'required|boolean',
            'password' => 'exclude_if:role_id,'.Role::ROLE_PARTICIPANT.'|exclude_if:random_password,true|required|nullable|string|confirmed',
            'phone' => 'sometimes|string|nullable',
            'address' => 'sometimes|string|nullable',
            'state' => ['exclude_unless:role_id,'.Role::ROLE_PARTICIPANT,'required',Rule::in(User::STATES)],
            'role_id' => 'required|exists:roles,id',

            //Role is provider
            'provider' => 'exclude_unless:role_id,'.Role::ROLE_PROVIDER.'|required|array',
            'provider.abn' => 'required|digits:11|unique:providers,abn',
            //'provider.business_name' => 'required|string',

            'provider.participants' => 'sometimes|array',
            'provider.participants.*' => 'integer|exists:participants,user_id',

            'provider.items' => 'sometimes|array',
            'provider.items.*' => 'exists:services,support_item_number',

            //Role is participant
            'participant' => 'exclude_unless:role_id,'.Role::ROLE_PARTICIPANT.'|required|array',
            'participant.representative_id' => 'sometimes|nullable|exists:representatives,user_id',
            'participant.ndis_number' => 'required|string|unique:participants,ndis_number',
            'participant.dob' => 'required|string',
            'participant.providers' => 'sometimes|array',
            'participant.providers.*' => 'integer',

            'participant.plan' => 'required|array',
            'participant.plan.plan_name' => 'required|string',
            'participant.plan.start_date' => 'required|string',
            'participant.plan.end_date' => 'required|string',
            'participant.plan.budget' => 'required|integer',
            'participant.plan.charges_types' => 'required|string',

            //Role is representative
            'representative' => 'exclude_unless:role_id,'.Role::ROLE_REPRESENTATIVE.'|sometimes|array',
            'representative.participants.*' => 'integer|exists:participants,user_id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'role_id.required' => 'The role field is required.',
        ];
    }
}


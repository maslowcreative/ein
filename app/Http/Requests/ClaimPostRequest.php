<?php

namespace App\Http\Requests;

use App\Models\Claim;
use App\Models\Participant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClaimPostRequest extends FormRequest
{
    private $role;
    private $is_admin;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
            $this->this_admin = false;
            $provider = optional(auth()->user())->provider;
            if($provider){

                $this->role = 'provider';
                return true;
            }

            $representative = optional(auth()->user())->representative;
            if($representative){
                $this->role = 'representative';
                return true;
            }

            $this->is_admin = optional(auth()->user()->hasRole('admin'));
            if($this->is_admin){
                $this->role = $this->request->get('action_role');
                return true;
            }

            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $yesterday = Carbon::now()->toDateString();

        $rule =  [
            'start_date' => 'required|date|before_or_equal:'.$yesterday,
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:'.$yesterday,
            'file' => 'required|file|mimes:pdf|max:3072',
            'service' => 'required|array',
            'service.*.item_number' => 'required|exists:services,support_item_number',
            'service.*.claim_type' => ['nullable','string',Rule::in(collect(Claim::CLAIM_TYPES)->keys()->toArray())],
            'service.*.cancellation_reason' => ['exclude_unless:service.*.claim_type,CANC','required',Rule::in(collect(Claim::CANCELLATION_REASONS)->keys()->toArray())],
            'service.*.hours' => 'required|numeric|min:0.01',
            'service.*.unit_price' => 'required|numeric|min:0.1',
            'service.*.gst_code' => ['required',Rule::in(collect(Claim::TAX_TYPES)->keys()->toArray())],
        ];

        if(!$this->is_admin)
        {
            if($this->role == 'provider'){
                $rule['participant_id'] = 'required|exists:provider_participant,participant_id,provider_id,'.auth()->user()->id;
                $rule['invoice_number'] = 'required|string|unique:claims,claim_reference,null,null,provider_id,'.auth()->user()->id;
            }

            if($this->role == 'representative'){
                $rule['participant_id'] = 'required|exists:participants,user_id,representative_id,'.auth()->user()->id;
                $rule['provider_id'] = 'required|exists:provider_participant,provider_id,participant_id,'.request()->participant_id;
                $rule['invoice_number'] = 'required|string|unique:claims,claim_reference,null,null,provider_id,'.$this->provider_id;
            }
        }
        else
        {
            $rule['participant_id'] = 'required|exists:participants,user_id';
            $rule['provider_id'] = 'required|exists:provider_participant,provider_id,participant_id,'.$this->participant_id;
            $rule['invoice_number'] = 'required|string|unique:claims,claim_reference,null,null,provider_id,'.$this->provider_id;
        }

        return $rule;
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Claim;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClaimPostRequest extends FormRequest
{
    private $role;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule =  [
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'invoice_number' => 'required|string|unique:claims,claim_reference,null,null,provider_id,'.auth()->user()->id,
            'file' => 'required|file|mimes:pdf',
            //required_if:anotherfield,value,...

            'service' => 'required|array',
            'service.*.item_number' => 'required|exists:services,support_item_number',
            'service.*.claim_type' => ['nullable',Rule::in(collect(Claim::CLAIM_TYPES)->keys()->toArray())],
            'service.*.cancellation_reason' => ['exclude_unless:service.*.claim_type,CANC','required',Rule::in(collect(Claim::CANCELLATION_REASONS)->keys()->toArray())],
            'service.*.hours' => 'required|numeric|min:0.1',
            'service.*.unit_price' => 'required|numeric|min:0.1',
            'service.*.gst_code' => ['required',Rule::in(collect(Claim::TAX_TYPES)->keys()->toArray())],
        ];

        if($this->role == 'porvider'){
            $rule['participant_id'] = 'required|exists:provider_participant,participant_id,provider_id,'.auth()->user()->id;
        }

        if($this->role == 'representative'){
            $rule['participant_id'] = 'required|exists:participants,user_id,representative_id,'.auth()->user()->id;
            $rule['provider_id'] = 'required|exists:provider_participant,provider_id,participant_id,'.request()->participant_id;
        }
        return $rule;
    }
}

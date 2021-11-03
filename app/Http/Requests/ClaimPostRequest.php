<?php

namespace App\Http\Requests;

use App\Models\Claim;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClaimPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return optional(auth()->user())->provider ? true: false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'invoice_number' => 'required|unique:claims,claim_reference,null,null,provider_id,'.auth()->user()->id,
            'participant_id' => 'required|exists:provider_participant,participant_id,provider_id,'.auth()->user()->id,
            'service' => 'required|array',

            'service.*.item_number' => 'required|exists:services,support_item_number',
            'service.*.claim_type' => ['nullable',Rule::in(collect(Claim::CLAIM_TYPES)->keys()->toArray())],
            'service.*.hours' => 'required|date_format:H:i',
            'service.*.unit_price' => 'required|numeric',
            'service.*.gst_code' => ['required',Rule::in(collect(Claim::TAX_TYPES)->keys()->toArray())],
        ];
    }
}

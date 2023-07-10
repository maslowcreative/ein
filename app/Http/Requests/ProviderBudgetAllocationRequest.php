<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderBudgetAllocationRequest extends FormRequest
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
            'plan_id' => 'required',
            'category_id' => 'required',
            'participant_id' => 'required',
            'providers_collection' => 'bail|required|array',
            'providers_collection.*.providerItemsResultSelected.id' => 'bail|required|distinct|exists:provider_participant,provider_id,participant_id,'.$this->participant_id,
            'providers_collection.*.budget' => 'required',
        ];
    }
}

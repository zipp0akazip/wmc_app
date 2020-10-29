<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelAddAliasRequest extends FormRequest
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
            'label_id' => 'required|exists:App\Models\LabelsModel,id',
            'alias' => 'required|min:3'
        ];
    }
}

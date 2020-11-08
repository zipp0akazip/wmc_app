<?php

namespace App\Http\Requests\Label;

use App\Models\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class AddAliasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(PermissionEnum::LabelAddAlias);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label_id' => 'required|exists:' . \App\Models\LabelModel::class . ',id',
            'alias' => 'required|min:3'
        ];
    }
}

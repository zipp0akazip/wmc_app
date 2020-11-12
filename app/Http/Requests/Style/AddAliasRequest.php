<?php

namespace App\Http\Requests\Style;

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
        return $this->user()->can(PermissionEnum::StyleAddAlias);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'style_id' => 'required|exists:' . \App\Models\StyleModel::class . ',id',
            'alias' => 'required|min:3'
        ];
    }
}

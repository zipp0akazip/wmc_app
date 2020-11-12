<?php

namespace App\Http\Requests\Label;

use App\Models\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can(PermissionEnum::LabelCreate);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:' . \App\Models\LabelModel::class . ',name',
        ];
    }
}

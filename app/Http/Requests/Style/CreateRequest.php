<?php

namespace App\Http\Requests\Style;

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
        return $this->user()->can(PermissionEnum::StyleCreate);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'required|exists:' . \App\Models\StyleModel::class . ',id',
            'name' => 'required|min:3|unique:' . \App\Models\StyleModel::class . ',name',
        ];
    }
}

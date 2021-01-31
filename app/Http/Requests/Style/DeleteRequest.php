<?php


namespace App\Http\Requests\Style;

use App\Models\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can(PermissionEnum::StyleDelete);
    }

    public function rules()
    {
        return [
            'style_id' => 'required|exists:' . \App\Models\StyleModel::class . ',id',
        ];
    }
}

<?php

namespace MatinEbrahimii\ToDo\Http\Requests\Label;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LabelStoreRequest extends FormRequest
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
            'title' => 'required|string|max:32|unique:labels',
            'description' => 'nullable|string|max:255',
        ];
    }
}

<?php

namespace MatinEbrahimii\ToDo\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class AssignLabelRequest extends FormRequest
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
            'labels' => 'required|array'
        ];
    }
}

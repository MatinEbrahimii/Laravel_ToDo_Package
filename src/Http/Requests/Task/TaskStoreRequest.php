<?php

namespace MatinEbrahimii\ToDo\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'title' => 'required|string|max:32',
            'description' => 'nullable|string|max:255',
            'labels' => 'nullable|array',
            'user_id' => 'nullable|integer|min:1',
        ];
    }
}

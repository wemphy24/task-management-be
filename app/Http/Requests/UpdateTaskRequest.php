<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        Auth::check(); // check if user logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            // 'description' => 'string|max:255',
            // 'due_date' => 'required',
            // 'assign_by' => 'required|string',
            // 'user_id' => 'required|integer',
            // 'status' => 'required',
            // 'task_start' => 'required',
            // 'task_complete' => 'nullable',
        ];
    }
}

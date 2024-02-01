<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagePostCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'thumbnail' => 'required|image|max:2048',
            'status' => 'integer',
        ];
    }
}

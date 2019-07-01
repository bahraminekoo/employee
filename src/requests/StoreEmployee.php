<?php

namespace Bahraminekoo\Employee\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployee extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|max:255|unique:employees,email',
            'doe' => 'date|required',
            'manager_id' => 'sometimes|exists:employees,id',
        ];
    }
}

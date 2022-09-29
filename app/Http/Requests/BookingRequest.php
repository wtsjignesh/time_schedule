<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookingRequest extends FormRequest
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
            'email' => 'required|array',
            'email.*' => 'email',
            'first_name' => 'required|array',
            'last_name' => 'required|array',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'user_id.required' => 'User ID is required',
            'category_id.required' => 'Category ID is required',
            'date.required' => 'Booking date is required',
            'start_time.required' => 'Booking time is required'
        ];
    }
}

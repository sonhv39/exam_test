<?php

namespace App\Http\Requests\hotel;

use App\Helper\CommonConst;
use Illuminate\Foundation\Http\FormRequest;

class EditHotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_id' => 'required|exists:hotels,hotel_id',
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|exists:prefectures,prefecture_id',
            'hotel_type' => 'required|string|in:' . implode(',', array_keys(CommonConst::HOTEL_TYPE_IMG)),
            'description' => 'nullable|string',
            'hotel_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'hotel_id.required' => 'Hotel ID is required',
            'hotel_id.exists' => 'Selected hotel is invalid',
            'hotel_name.required' => 'Hotel name is required',
            'hotel_name.max' => 'Hotel name cannot exceed 255 characters',
            'prefecture_id.required' => 'Please select a prefecture',
            'prefecture_id.exists' => 'Selected prefecture is invalid',
            'hotel_type.required' => 'Please select a hotel type',
            'hotel_type.in' => 'Selected hotel type is invalid',
            'hotel_image_file.image' => 'The file must be an image',
            'hotel_image_file.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif',
            'hotel_image_file.max' => 'The image may not be greater than 2MB'
        ];
    }
} 
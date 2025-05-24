<?php

namespace App\Http\Requests\hotel;

use App\Helper\CommonConst;
use Illuminate\Foundation\Http\FormRequest;

class CreateHotelRequest extends FormRequest
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
            'hotel_name' => 'required|string|max:255',
            'prefecture_id' => 'required|exists:prefectures,prefecture_id',
            'description' => 'nullable|string|max:1000',
            'hotel_type' => 'required|in:' . implode(',', array_keys(CommonConst::HOTEL_TYPE_IMG)),
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
            'hotel_name.required' => 'Hotel name is required',
            'hotel_name.max' => 'Hotel name must not exceed 255 characters',
            'prefecture_id.required' => 'Prefecture is required',
            'prefecture_id.exists' => 'Selected prefecture is invalid',
            'description.max' => 'Hotel description must not exceed 1000 characters',
            'hotel_type.required' => 'Hotel type is required',
            'hotel_type.in' => 'Selected hotel type is invalid',
            'hotel_image_file.image' => 'The uploaded file must be an image',
            'hotel_image_file.mimes' => 'Image must be in jpeg, png, jpg, or gif format',
            'hotel_image_file.max' => 'Image size must not exceed 2MB'
        ];
    }
}

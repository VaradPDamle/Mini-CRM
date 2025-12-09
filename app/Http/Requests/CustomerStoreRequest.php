<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * * Since this form is inside an 'auth' middleware group, we allow all authenticated users (Admin/Staff)
     * to access this creation form.
     */
    public function authorize(): bool
    {
        // Must return true to allow the request to proceed to the controller
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
            // Customer model fields: name, email, phone, address, profile_image
            'name' => ['required', 'string', 'max:255'],
            // 'unique:customers' ensures the email doesn't already exist in the customers table
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            
            // Validation rules for file upload
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 'image' ensures it's an image file
        ];
    }
}
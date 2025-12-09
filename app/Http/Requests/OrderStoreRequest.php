<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Since this is within the 'auth' middleware group, we allow all authenticated users (Admin/Staff)
     * to proceed with creating an order.
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
            // Ensure a valid customer is selected
            'customer_id' => ['required', 'exists:customers,id'], 
            
            // Order number must be unique in the 'orders' table
             'order_number' => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('orders')->ignore($this->order)],
            
            // Amount must be a number greater than zero
            'amount' => ['required', 'numeric', 'min:0.01'],
            
            // Status must be one of the predefined options
            'status' => ['required', 'string', 'in:Pending,Completed,Cancelled'], 
            
            // Date must be in a valid date format
            'order_date' => ['required', 'date'],
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
{
    public function authorize()
    {
        $business = $this->route('business');
        $user = $this->user();

        // Allow update if the user owns the business or is the admin
        return ($business && $user->can('update', $business)) ||
            $user->email === 'admin@equinehire.com';
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|string',
            'address' => 'required',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'nullable|string',
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'phone' => 'nullable|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
            'categories' => 'nullable|array',
            'disciplines' => 'nullable|array',
            'logo' => 'nullable|url',
            'featured_image' => 'nullable|url',
        ];
    }
    public function messages()
    {
        return [
            // Custom validation messages
            'name.required' => 'The business name is required.',
        ];
    }
}

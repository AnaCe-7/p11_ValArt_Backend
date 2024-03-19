<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtworkRequest extends FormRequest
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
            'title' => 'required|max:255|min:3',
            'description' => 'required|max:255|min:15',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'classification' => 'required|in:Pintura,Escultura,Dibujo,Artesanía,Grabado,Ceramica,Orfebreria',
            'technique' => 'required|max:255|min:15',
            'details' => 'nullable|max:255|min:15',
            'measures' => 'required|max:40|min:3',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends DefaultRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules =[
            'post_id' => 'required|exists:posts,id', // Check if the post_id exists in the posts table
            'react_type' => 'required|string', 
        ];
        return $rules;
    }
}

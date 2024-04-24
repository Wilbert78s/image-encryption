<?php

namespace App\Http\Requests;

use App\Rules\Prime;
use Illuminate\Foundation\Http\FormRequest;

class DecryptRequest extends FormRequest
{
   
    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'p1' => ['integer', new Prime],
            'p2' => ['integer', new Prime],
            'k1' => 'integer|between:1,8',
            'k2' => 'integer|between:1,8',
            'x0' => 'numeric|gt:0|lt:1',
            'a0' => 'numeric|gt:0|lte:4',
            'x1' => 'numeric|gt:0|lt:1',
            'a1' => 'numeric|gt:0|lte:4',
            'a' => 'integer|gt:500',
            'b' => 'integer|gt:500',   
            'width' => 'integer|gt:0|lte:512',   
            'height' => 'integer|gt:0|lte:512',   
            'hashing' => [ 'size:256', 'regex:/^[01]+$/'],   
        ];
    }
}

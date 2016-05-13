<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\JsonForcedRequest;

class CompanySearchGisRequest extends JsonForcedRequest
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
            'type' => 'required|in:circle,rectangle',
            'coords' => 'required|array',
            'coords.*' => 'required|numeric',
            'coords.2' => 'required_if:type,rectangle|numeric',
            'coords.3' => 'required_if:type,rectangle|numeric',
            'radius' => 'required_if:type,circle|numeric'
        ];
    }
}

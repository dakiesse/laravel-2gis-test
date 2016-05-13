<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\CleanPaginateRequestTrait;
use App\Http\Requests\JsonForcedRequest;

class BuildListRequest extends JsonForcedRequest
{
    use CleanPaginateRequestTrait;

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
        $this->clearPaginateParams();

        return [
            'limit' => 'integer|min:-1',
            'page' => 'integer|min:1',
        ];
    }
}

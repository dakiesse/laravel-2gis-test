<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\CleanPaginateRequestTrait;
use App\Http\Requests\JsonForcedRequest;
use Illuminate\Support\Facades\Input;

class CompanySearchRequest extends JsonForcedRequest
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
            'id' => 'integer',
            'build_id' => 'integer',
            'category_id' => 'integer',
            'name' => 'string',
            'limit' => 'integer|min:-1',
            'page' => 'integer|min:1',
        ];
    }
}

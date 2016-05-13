<?php

namespace App\Http\Requests;

trait CleanPaginateRequestTrait
{
    private function clearPaginateParams()
    {
        $input = $this->all();

        foreach (['limit', 'offset'] as $param) {
            if (isset($input[$param]) && empty($input[$param])) {
                unset($input[$param]);
            }
        }

        $this->query->replace($input);
        $this->request->replace($input);
    }
}
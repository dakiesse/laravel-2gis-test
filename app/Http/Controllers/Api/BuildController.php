<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Api\BuildListRequest;
use App\Models\Build;
use Illuminate\Support\Collection;

class BuildController extends Controller
{
    /**
     * Поиск компаний по различным ее критериями.
     * GET
     *
     * @param int $limit Необходимое кол-во записей (-1 вывести все) (default: 100)
     * @param int $page  Номер страницы (offset) (default: 1)
     *
     * @return Response
     */
    public function getList(BuildListRequest $request)
    {
        $limit = (int)$request->get('limit', 100);
        $page = (int)$request->get('page', 0);

        $buildings = (new Build)->limit($limit)->orderBy('id')->paginate($limit);

        return response()->json([
            'count' => $buildings->count(),
            'total' => $buildings->total(),
            'current_page' => $page,
            'last_page' => $buildings->lastPage(),
            'result' => $buildings->all(),
        ]);
    }
}

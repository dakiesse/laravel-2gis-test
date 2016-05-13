<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\Api\CompanySearchGisRequest;
use App\Http\Requests\Api\CompanySearchRequest;
use App\Models\Company;
use Illuminate\Support\Collection;

class CompanyController extends Controller
{
    /**
     * Поиск компаний по различным ее критериями.
     * GET /api/v1/companies/search
     *
     * @param int    $id          ID компании
     * @param int    $build_id    ID здания в котором необходимо найти компании
     * @param int    $category_id ID рубрики в которой необходимо найти компании
     * @param string $name        Имя компании (поиск по шаблону %value%)
     * @param int    $limit       Необходимое кол-во записей (-1 вывести все) (default: 100)
     * @param int    $page        Номер страницы (offset) (default: 1)
     *
     * @return \App\Http\Controllers\Api\Response
     */
    public function getSearch(CompanySearchRequest $request, Company $company)
    {
        $queries = $request->intersect(['id', 'build_id', 'category_id', 'name']);
        $limit = (int)$request->get('limit', 100);
        $page = (int)$request->get('page', 0);

        // TODO: вынести в CompanySearchRequest
        if (empty($queries)) {
            return response()->json(['message' => 'Query parameters are not defined'], 404);
        }

        $companies = $company->search($queries)->with('categories', 'build')->orderBy('id')->paginate($limit);

        return response()->json([
            'count' => $companies->count(),
            'total' => $companies->total(),
            'current_page' => $page,
            'last_page' => $companies->lastPage(),
            'result' => $companies->all(),
        ]);
    }

    /**
     * Поиск компаний по различным ее критериями.
     * GET /api/v1/companies/search_gis
     *
     * @param string $type   Тип полигона/фигуры в котором необходимо найти компании. Возможные значения: circle,
     *                       rectangle
     * @param array  $coords Массив координат. Если type - circle: lat и lng центральной точки [2]. Если type -
     *                       rectangle: lat и lng для верхней левой точки и для нижней правой точки [4].
     * @param float  $radius Радиус для type - circle
     *
     * @return \App\Http\Controllers\Api\Response
     */
    public function getSearchGis(CompanySearchGisRequest $request, Company $company)
    {
        $coords = $request->get('coords');

        // Если будут еще какие либо шейпы (shape), стоит вынести в репозиторий для reusable,
        // но текущее решение для текущей задачи не делает метод толстым
        switch ($request->get('type')) { // В switch зайдет 100%
            case 'circle':
                $company = $company->whereBuildingInGisCircle($coords[0], $coords[1], $request->get('radius', 0));
                break;
            case 'rectangle':
                $company = $company->whereBuildingInGisRectangle($coords[0], $coords[1], $coords[2], $coords[3]);
                break;
        }

        $companies = $company->with('build')->get();

        return response()->json([
            'count' => $companies->count(),
            'result' => $companies,
        ]);
    }
}

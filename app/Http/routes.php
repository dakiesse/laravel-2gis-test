<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Models\Build;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

get('/', function () {
    return view('welcome');
});

get('docs', function () {
    return view('docs.api.v1.index');
});

group([
    'prefix' => 'api/v1',
    'middleware' => 'web',
    'namespace' => 'Api',
    'as' => 'api:v1:',
], function () {
    get('companies/search', ['as' => 'companies.search', 'uses' => 'CompanyController@getSearch']);
    get('companies/search_gis', ['as' => 'companies.search_gis', 'uses' => 'CompanyController@getSearchGis']);

    get('buildings/list', ['as' => 'buildings.list', 'uses' => 'BuildController@getList']);
});


Route::get('/api/v1/buildings', function (Request $request) {
    $coords = $request->get('coords');
    $scopeBuildings = null;

    switch ($request->get('type')) {
        case 'circle':
            $radius = $request->get('radius', 0);

            $scopeBuildings = (new Build)
                ->whereRaw(
                    sprintf(
                        'ST_DWithin(location::geometry, ST_GeomFromText(\'POINT(%s %s)\', 4326), 0.000009009009009 * %s)',
                        $coords[0], $coords[1], $radius
                    )
                )
                ->get();
            break;
        case 'rectangle':
            $scopeBuildings = (new Build)
                ->whereRaw(
                    sprintf(
                        'ST_Contains(ST_SetSRID(ST_MakeBox2D(ST_Point(%s, %s), ST_Point(%s, %s)), 4326), location::geometry)',
                        $coords[0][0], $coords[0][1], $coords[1][0], $coords[1][1]
                    )
                )->get();
    }

    return response()->json($scopeBuildings);
});

Route::get('/api/v1/companies', function (Request $request) {
    $companies = (new Company);

    foreach ($request->only(['id', 'build_id', 'name']) as $paramName => $paramValue) {
        if (!$paramValue) {
            continue;
        }

        if ($paramName === 'name') {
            $companies = $companies->where('name', 'like', "%$paramValue%");
        } else {
            $companies = $companies->where($paramName, $paramValue);
        }
    }

    $companies = $companies->get();

    return response()->json($companies);
});

Route::get('/api/v1/search', function (Request $request) {
    $query = $request->get('q');

    $first = DB::table('companies')
        ->select('id')
        ->addSelect(DB::raw('\'company\' as entity'))
        ->addSelect('name as value')
        ->where('name', 'ilike', "%$query%");

    $searchResult = DB::table('buildings')
        ->select('id')
        ->addSelect(DB::raw('\'build\' as entity'))
        ->addSelect('street as value')
        ->where('street', 'ilike', "%$query%")
        ->union($first)
        ->limit(10)
        ->get();

    return response()->json($searchResult);
});

Route::get('/api/v1/firm/search', function (Request $request) {
    $query = $request->get('q');

    $first = DB::table('companies')
        ->select('id')
        ->addSelect(DB::raw('\'company\' as entity'))
        ->addSelect('name as value')
        ->where('name', 'ilike', "%$query%");

    $searchResult = DB::table('buildings')
        ->select('id')
        ->addSelect(DB::raw('\'build\' as entity'))
        ->addSelect('street as value')
        ->where('street', 'ilike', "%$query%")
        ->union($first)
        ->limit(10)
        ->get();

    return response()->json($searchResult);
});

Route::get('tt', function (Request $request) {
    $leafIds = [];
    $tree = (new Category)->all()->toTree();

    $leafIds = collectionModelRelationsMapRecursive($tree, 'children', function (Model $model) {
        return $model->id;
    });

    return response()->json($leafIds);
});


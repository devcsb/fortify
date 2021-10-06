<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class WorknetController extends Controller
{
    //

    public function index(Request $request)
    {

        $url = "http://openapi.work.go.kr/opi/opi/opia/wantedApi.do?authKey=WNJMLNKRTD2G7YSC0I5AA2VR1HJ&callTp=L&returnType=XML&startPage=1&display=100";

        $XmlDataString = file_get_contents($url);
        $xmlObject = simplexml_load_string($XmlDataString);

        $json = json_encode($xmlObject);
        $DataArr = json_decode($json, true);
        $worknets = $DataArr['wanted'];

        $search = $request->input('search');
        // foreach ($worknets as $worknet)
        $search_value = array_search($search, array_column($worknets, '학원'));
        dd($search_value);
        // dd($worknets[$search_value]);
        // dd($search_value);

        $worknets = $this->paginate($worknets);
        $worknets->withPath('worknets');



        return view('worknets.index', compact('worknets'))->withDetails([$worknets])->withQuery($search_value);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

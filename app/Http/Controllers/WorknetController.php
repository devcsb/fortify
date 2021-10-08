<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class WorknetController extends Controller
{
    public function paginate($total, $items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);
        
        return new LengthAwarePaginator($items, $total, $perPage, $page, $options);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->get('page');
        
        $url = "http://openapi.work.go.kr/opi/opi/opia/wantedApi.do";

        $default_var = "?authKey=WNJMLNKRTD2G7YSC0I5AA2VR1HJ&callTp=L&returnType=XML&startPage=" . $page . "&display=10";
        $addisonal_var =
        ["keyword" => "&keyword=".$search,
        ];


        $response = Http::get($url.$default_var.$addisonal_var['keyword']);
        $xmlObject = simplexml_load_string($response->body());   //XML 문자열을 XML 객체로 변환
        $json = json_encode($xmlObject);    //xml형식 객체를 json으로 변환(xml문자열을 곧바로 json_encode할 수 없다. 객체로 변환 후 json으로 변환해야 함)
        $DataArr = json_decode($json, true);

        // $DataArr = json_decode(json_encode(simplexml_load_string($response->body())), true);

        if (isset($DataArr['messageCd'])) {
            $message = "검색조건에 일치하는 결과가 없습니다.";
            return view('worknets.index', compact('message'));
        } else {
        }
        $worknets = $DataArr['wanted'];
        $total = $DataArr['total'];
        $worknets = $this->paginate($total, $worknets);
        $worknets->withPath('worknets');
        $message = "총 ".$total."건의 결과가 검색되었습니다.";

        return view('worknets.index', compact('worknets', 'message', 'total'));
    }

    public function show($authNum)
    {
        $detail_url = "http://openapi.work.go.kr/opi/opi/opia/wantedApi.do";
        $detail_var ="?authKey=WNJMLNKRTD2G7YSC0I5AA2VR1HJ&callTp=D&returnType=XML&wantedAuthNo=" . $authNum . "&infoSvc=VALIDATION";
        $response = Http::get($detail_url.$detail_var);
        
        $xmlObject = simplexml_load_string($response);
        $json = json_encode($xmlObject);
        $worknets = json_decode($json, true);



        return view('worknets.show', compact('worknets', 'authNum'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Qnaboard;
use Illuminate\Http\Request;

class QnaboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $qnas = Qnaboard::orderByDesc('group')->get(); // orderby만 쓰면 제대로 가져오지 못한다. get() 체인해줘야함.

        return view('qnas.index', compact('qnas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('qnas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $selectRow = Qnaboard::orderByDesc('id')->get('id')->first(); // 리턴값 형식 collection
        if(isset($selectRow)) // orderbyDesc 정렬 후 그 첫 값이 존재할 때. 즉, 누적된 글이 1개라도 있을 때
        {
            $lastId = $selectRow['id']; //collection에서 id값 추출
        }

        $qna = new Qnaboard([
            'author' => $request->input('author'),
            'password'=> $request->input('password'),
            'secret_flag'=> $request->input('secret_check'),
            'title'=> $request->input('title'),
            'content'=>$request->input('content'),
            'group'=>$lastId+1,
            'step'=>0,
            'indent'=> 0,
        ]);
        $qna->save();

        return redirect()->route('qnas.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Qnaboard $qna)
    {
        if($qna->secret_flag==1){
            self::checkpw($qna);
        }

        return view('qnas.show', compact('qna'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkpw($pw)
    {
//       redirect()->view();
    }
}

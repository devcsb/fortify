<?php

namespace App\Http\Controllers;

use App\Models\Qnaboard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use RealRashid\SweetAlert\Facades\Alert;

class QnaboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $qnas = Qnaboard::orderByDesc('group')->get(); // orderby만 쓰면 제대로 가져오지 못한다. get() 체인해줘야함.
//        $qnas = Qnaboard::where('step','==','0')->orderByDesc('group')->get(); //원본 글만 전달

        return view('qnas.index', compact('qnas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('qnas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $selectRow = Qnaboard::orderByDesc('id')->get('id')->first(); // 리턴값 형식 collection
        if (isset($selectRow)) // orderbyDesc 정렬 후 그 첫 값이 존재할 때. 즉, 누적된 글이 1개라도 있을 때
        {
            $lastId = $selectRow['id']; //collection에서 id값 추출
        } else {
            $lastId = 0;
        }

        $qna = new Qnaboard([
            'author' => $request->input('author'),
            'password' => Hash::make($request->input('password')),
            'secret_flag' => $request->input('secret_check'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'group' => $lastId + 1,
            'step' => 0,
            'indent' => 0,
        ]);
        $qna->save();

        return redirect()->route('qnas.index');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show(Qnaboard $qna)
    {
        //비밀글이면서 session에 verified 값이 없을 때(check 통과하지 않았을 때)
        if ($qna->secret_flag == 1 && !Session::has('verified')) { // session flash 값은 다음 http요청시 바로 삭제됨
            return $this->inputPw($qna->id, 'show', $qna->password);
        }

        return view('qnas.show', compact('qna'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Qnaboard $qna)
    {
        return view('qnas.edit', compact('qna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Qnaboard $qna)
    {
        $qna=Qnaboard::firstWhere('id',$qna->id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Qnaboard $qna
    ) // Route Model Binding 규칙에 의거, 라우트에서 명시한 세그먼트 값{qna}와 일치하는 $qna 파라미터로 받아야 묵시적 바인딩이 자동으로 됨.
    {

        if (!Session::has('verified')) { // session flash 값은 다음 http요청시 바로 삭제됨
            return $this->inputPw($qna->id, 'destroy', $qna->password);
        }
        $qna->delete();

        return redirect()->route('qnas.index');
    }


    /**
     * @param string $qnaId
     * @param string $caller
     * @param string $password
     * @return Application|Factory|View
     */
    public function inputPw(string $qnaId, string $caller, string $password)
    {

        //if문으로 show, destroy시 각각 폼 입력 뷰페이지 return값 다르게 설정하기. destroy시 폼 메서드 스푸핑해야하므로
        return view('qnas.input_pw', compact('qnaId', 'caller', 'password'));
    }

    /**
     * @param string $qnaId
     * @param string $caller
     * @param Request $request
     * @return RedirectResponse
     */
    public function checkPw(string $qnaId, string $caller, Request $request)
    {
        $qna = Qnaboard::whereId($qnaId)->first();

        $dbPassword = Qnaboard::whereId($qnaId)->first()->password;
        $verified = Hash::check($request->password, $dbPassword);

        if ($verified) {
            if ($caller == 'show') {
                return redirect()->route('qnas.show', compact('qna'))->with(['verified' => $verified]);
            }
            if ($caller == 'destroy') {
//                return redirect()->route('qnas.destroy', $qna->id)->with(['verified' => $verified]);
//                return redirect()->action([QnaboardController::class, 'create'],['qna'=>$qnaId])->header('');

                Qnaboard::destroy($qnaId);
                Alert::success('삭제 성공', '문의글이 성공적으로 삭제되었습니다');
                return redirect()->route('qnas.index');
            }
        } else {
            Alert::error('비밀번호 오류', '비밀번호가 틀렸습니다');
            return redirect()->back();
        }
    }

}

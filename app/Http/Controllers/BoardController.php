<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')
            ->except(["index", "show"]);
    }

    public function index(Request $request)
    {
        //검색기능 추가
        $boards = Board::where('title', 'Like', '%' . $request->search . '%')->orderByDesc('id')->paginate(5);
        // $boards = Board::orderByDesc('id')->paginate(5);


        return view('boards.index', compact('boards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardRequest $request)
    {
        //유효성체크와 동시에 create하겠다는 파사드
        // Board::create($request->validated());

        //RequestForm에서는 유효성 체크만 하고 비즈니스로직을 넣지말고 아래와 같이 유효성 값만 반환받아 컨트롤러에서 작성하자.
        $validated = $request->validated();
        $board = new Board([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $validated['file']->getClientOriginalName();
            $filePath = $validated['file']->storeAs('uploads', $fileName, 'public'); // storeAs($path, $name, $disk); 세번째 $disk는 옵션. $disk에는 filesystems.php에서 정의한 disk를 선택
            $board->file_name = $fileName;
            $board->file_path = $filePath;
        }

        $board->save();



        return redirect()->route('boards.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
        return view('boards.show', compact('board'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //권한제어
        // if ($board->email !== auth()->email()) {  //새로 만든 함수라서 에디터에서 인식 못하는 문제? or Auth/SessionGuard 커스텀시 수정해야하는 코드가 있는지?
        //     abort(403);
        // }

        //위 코드를 abort_if 헬퍼함수로 한줄로 요약
        // abort_if($board->email !== auth()->email(), 403);

        //Policy 사용한 권한제어
        $this->authorize('view', $board);

        return view('boards.edit', compact('board'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        //권한제어
        // if ($board->email !== auth()->email()) {  //새로 만든 함수라서 에디터에서 인식 못하는 문제? or Auth/SessionGuard 커스텀시 수정해야하는 코드가 있는지?
        //     abort(403);
        // }

        //위 코드를 abort_if 헬퍼함수로 한줄로 요약
        // abort_if($board->email !== auth()->email(), 403);

        //Policy 사용한 권한제어 // 책 366p. 첫번 째 파라미터로 어빌리티명, 두 번째로 객체를 받는 authorize()함수
        $this->authorize('update', $board);


        // $board->update($request->all());

        $validated = $request->validated();

        dd($request);
        // $board = new Board([
        //     'name' => $validated['name'],
        //     'email' => $validated['email'],
        //     'title' => $validated['title'],
        //     'content' => $validated['content'],
        // ]);
        // if ($request->hasFile('file')) {
        //     $fileName = time() . '_' . $validated['file']->getClientOriginalName();
        //     $filePath = $validated['file']->storeAs('uploads', $fileName, 'public'); // storeAs($path, $name, $disk); 세번째 $disk는 옵션. $disk에는 filesystems.php에서 정의한 disk를 선택
        //     $board->file_name = $fileName;
        //     $board->file_path = $filePath;
        // }

        // $board->save();



        return redirect()->route('boards.show', $board->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        // $board = Board::find($board);
        $board->delete();

        return redirect()->route('boards.index');
    }
}

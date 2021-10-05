<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use Illuminate\Http\Request;
use App\Models\Board;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\Input;

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
        $search = $request->input('search');


        $notices = Board::where('notice_flag', '=', 'Y')->orderBy('id')->paginate(10, ['*'], 'notice_page');
        $boards = Board::where('title', 'Like', '%' . $request->search . '%')->orderByDesc('id')->paginate(10, ['*'], 'page');

        //공지 1페이지에만 나오게 & 페이징 갯수에 공지글 포함
        // $boards = Board::where('title', 'Like', '%' . $request->search . '%')
        //     ->orderByRaw('FIELD(notice_flag,"Y","N")')
        //     ->orderByDesc('id')
        //     ->paginate(10);

        if (count($boards) > 0) {
            return view('boards.index', compact('boards', 'notices'))->withDetails([$boards, $notices])->withQuery($search);
        } else {
            return view('boards.index', compact('boards', 'notices'));
        }
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


        //파일명 변경위한 패턴 정의
        $pattern = '/[@\,\?\*\.\;\!\$\#\%\^\&\(\)\-\=\+\`\~\" "]+/';

        $notice_falg = $request->notice_flag;
        if ($request->notice_flag !== 'Y') {
            $notice_falg = 'N';
        };

        $board = new Board([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'notice_flag' => $notice_falg,     //input 받은 값이 null일 경우, validation Form Request에서 반환받은 값으로는 접근 불가하므로 request에서 직접 가져다쓴다.(배열에 없는 값이므로)
        ]);

        if ($request->hasFile('file')) {

            //이름변경 작업
            $origin_name_arr = explode('.', $validated['file']->getClientOriginalName());
            $origin_name = array_shift($origin_name_arr);
            $convert_name = preg_replace($pattern, '', $origin_name);


            //확장자 제어
            $ext = array_pop($origin_name_arr);
            $banned_ext = array('php', 'phps', 'php3', 'php4', 'php5', 'php7', 'pht', 'phtml', 'htaccess', 'html', 'htm', 'inc');
            if (in_array($ext, $banned_ext)) {
                abort(403, '이 확장자를 가진 파일은 업로드 할 수 없습니다.');
            }

            //파일명에 확장자 붙여주기
            $convert_name = $convert_name . "." . $ext;

            $fileName = time() . '_' . $validated['name'] . '_' . $convert_name;
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

        // $board = Board::find($validated['email']); //find 메서드는 인자로 받은 id값으로 해당 행을 검색한다. where문이 아님. id값만 검색하는 메서드
        $board = Board::firstWhere('email', $validated['email']);

        $board->name = $validated['name'];
        $board->email = $validated['email'];
        $board->title = $validated['title'];
        $board->content = $validated['content'];

        if ($request->input('file_remove') == 'remove') {
            File::delete(public_path() . '/storage/uploads/' . $board['file_name']);
            $board->file_name = null;
            $board->file_path = null;
        }

        //파일명 변경위한 패턴 정의
        $pattern = '/[@\,\?\*\.\;\!\$\#\%\^\&\(\)\-\=\+\`\~\" "]+/';

        if ($request->hasFile('file')) {

            if (File::exists(public_path() . '/storage/uploads/' . $board['file_name'])) {
                File::delete(public_path() . '/storage/uploads/' . $board['file_name']);
            }

            //이름변경 작업
            $origin_name_arr = explode('.', $validated['file']->getClientOriginalName());
            $origin_name = array_shift($origin_name_arr);
            $convert_name = preg_replace($pattern, '', $origin_name);


            //확장자 제어
            $ext = array_pop($origin_name_arr);
            $banned_ext = array('php', 'phps', 'php3', 'php4', 'php5', 'php7', 'pht', 'phtml', 'htaccess', 'html', 'htm', 'inc');
            if (in_array($ext, $banned_ext)) {
                abort(403, '이 확장자를 가진 파일은 업로드 할 수 없습니다.');
            }

            //파일명에 확장자 붙여주기
            $convert_name = $convert_name . "." . $ext;

            $fileName = time() . '_' . $validated['name'] . '_' . $convert_name;
            $filePath = $validated['file']->storeAs('uploads', $fileName, 'public'); // storeAs($path, $name, $disk); 세번째 $disk는 옵션. $disk에는 filesystems.php에서 정의한 disk를 선택
            $board->file_name = $fileName;
            $board->file_path = $filePath;
        }







        $board->save();

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
        $this->authorize('delete', $board);


        if (File::exists(public_path() . '/storage/uploads/' . $board['file_name'])) {
            File::delete(public_path() . '/storage/uploads/' . $board['file_name']);
        }

        $board->delete();

        return redirect()->route('boards.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use App\Models\BoardFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $boards = Board::where('title', 'Like', '%' . $request->search . '%')->orderByDesc('id')->paginate(
            10,
            ['*'],
            'page'
        );
        //공지 1페이지에만 나오게 & 페이징 갯수에 공지글 포함
        // $boards = Board::where('title', 'Like', '%' . $request->search . '%')
        //     ->orderByRaw('FIELD(notice_flag,"Y","N")')
        //     ->orderByDesc('id')
        //     ->paginate(10);

        return view('boards.index', compact('boards', 'notices'))->withDetails([$boards, $notices])->withQuery($search);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardRequest $request)
    {
        //유효성체크와 동시에 create하겠다는 파사드
        // Board::create($request->validated());

        //RequestForm에서는 유효성 체크만 하고 비즈니스로직을 넣지말고 아래와 같이 유효성 값만 반환받아 컨트롤러에서 작성하자.
        $validated = $request->validated();

        $notice_falg = $request->notice_flag;
        if ($request->notice_flag !== 'Y') {
            $notice_falg = 'N';
        }

        $board = new Board([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'notice_flag' => $notice_falg,
            //input 받은 값이 null일 경우, validation Form Request에서 반환받은 값으로는 접근 불가하므로 request에서 직접 가져다쓴다.(배열에 없는 값이므로)
        ]);
        $board->save();

        if ($request->hasFile('file')) {
            $seq = 0;
            foreach ($request->file('file') as $file) {
                $fileOriName = $file->getClientOriginalName();
                $fileName = substr($fileOriName, 0, strrpos($fileOriName, '.'));             // 확장자 뺀 파일명
                $fileExtension = strtolower($file->getClientOriginalExtension());      // 파일 확장자
                if (!in_array($fileExtension, ['jpeg', 'jpg', 'gif', 'png'])) {
                    abort(403, '이 확장자를 가진 파일은 업로드 할 수 없습니다.');
                }

                //파일명에 확장자 붙여주기
                $trimFileName = time() . '_' . $validated['name'] . '_' . $fileName . '.' . $fileExtension;
                $filePath = $file->storeAs(
                    'uploads',
                    $trimFileName,
                    'public'
                ); // storeAs($path, $name, $disk); 세번째 $disk는 옵션. $disk에는 filesystems.php에서 정의한 disk를 선택

                $file = new BoardFile([
                    'board_id' => $board->id,
                    'type' => 'board',
                    'seq' => ++$seq,
                    'file_name' => $trimFileName,
                    'file_path' => $filePath,
                ]);
                $file->save();
            }
        }
        return redirect()->route('boards.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        //권한제어
        // if ($board->email !== auth()->email()) {Auth/SessionGuard 커스텀시 수정해야하는 코드가 있는지?
        //     abort(403);
        // }

        //위 코드를 abort_if 헬퍼함수로 한줄로 요약
        // abort_if($board->email !== auth()->email(), 403);


        //Policy 사용한 권한제어 // 책 366p. 첫번 째 파라미터로 어빌리티명, 두 번째로 객체를 받는 authorize()함수
        $this->authorize('update', $board);

        $validated = $request->validated();

        $board->name = $validated['name'];
        $board->email = $validated['email'];
        $board->title = $validated['title'];
        $board->content = $validated['content'];

        if ($request->input('file_remove') == 'remove') {
            foreach ($board->files as $file) {
                File::delete(public_path() . '/storage/uploads/' . $file->file_name);
                $file->delete();
            }
        }

        if ($request->hasFile('file')) {
            $seq = 0;
            foreach ($board->files as $originalFile) {
                File::delete(public_path() . '/storage/uploads/' . $originalFile->file_name);
                $originalFile->delete();
            }

            foreach ($request->file('file') as $file) {
                $fileOriName = $file->getClientOriginalName();
                $fileName = substr($fileOriName, 0, strrpos($fileOriName, '.'));             // 확장자 뺀 파일명
                $fileExtension = strtolower($file->getClientOriginalExtension());      // 파일 확장자
                if (!in_array($fileExtension, ['jpeg', 'jpg', 'gif', 'png'])) {
                    abort(403, '이 확장자를 가진 파일은 업로드 할 수 없습니다.');
                }

                $trimFileName = time() . '_' . $validated['name'] . '_' . $fileName . '.' . $fileExtension;
                $filePath = $file->storeAs(
                    'uploads',
                    $trimFileName,
                    'public'
                );

                $file = new BoardFile([
                    'board_id' => $board->id,
                    'type' => 'board',
                    'seq' => ++$seq,
                    'file_name' => $trimFileName,
                    'file_path' => $filePath,
                ]);
                $file->save();
            }
        }

        $board->save();

        return redirect()->route('boards.show', $board->id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);


        foreach ($board->files as $file) {
            if (File::exists(public_path() . '/storage/uploads/' . $file->file_name)) {
                File::delete(public_path() . '/storage/uploads/' . $file->file_name);
            }
            $file->delete();
        }

        $board->delete();

        return redirect()->route('boards.index');
    }

}

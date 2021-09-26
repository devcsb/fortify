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
    public function index()
    {
        $boards = Board::get();
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
        Board::create($request->validated());

        //StoreBoardRequest.php에서 유효성체크하면서 바로 insert 했으므로 여기서 다시 저장하면 중복저장됨.

        // $board = new Board([
        //     'name' => $request->input('name'),
        //     'title' => $request->input('title'),
        //     'content' => $request->input('content')
        // ]);
        // $board->save();



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
        //
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
        //
        // $board->update($request->validate());

        // $board = Board::find(Board $board);
        // $board->title = $request->input('title');
        // $board->content = $request->input('content');

        $board->update($request->all());


        // [

        //     'title' => $request->input('title'),
        //     'content' => $request->input('content')
        // ];
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

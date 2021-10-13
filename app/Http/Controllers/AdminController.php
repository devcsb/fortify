<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function delete(Request $request)
    {
        $id = $request->id;
        Board::whereIn('id', $id)->delete();
        return response()->json(['success' => "게시글이 정상적으로 삭제되었습니다!"]);
    }


    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        Board::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "게시글이 정상적으로 삭제되었습니다!"]);
    }
}

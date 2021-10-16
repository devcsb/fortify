<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function delete(Request $request)
    {
        if(Gate::denies('manage-boards')){
            abort(403);
        }
        $id = $request->id;
        Board::where('id', $id)->delete();
        return response()->json(['success' => "게시글이 정상적으로 삭제되었습니다!"]);
    }


    public function deleteSelected(Request $request)
    {
        if(Gate::denies('manage-boards')){
            abort(403);
        }
        $ids = $request->ids;
        Board::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['success' => "게시글이 정상적으로 삭제되었습니다!"]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CKEditorController extends Controller
{

    public function ImageUpload(Request $request)
    {
        $CKEditorFuncNum = $request->input('CKEditorFuncNum');

        if ($request->hasFile('upload')) {
            $fileOriName = $request->file('upload')->getClientOriginalName();
            $fileName = substr($fileOriName, 0, strrpos($fileOriName, '.'));  //확장자 뺀 파일명
            $fileExtension = strtolower($request->file('upload')->getClientOriginalExtension()); // 파일 확장자

            $allow_ext = ['jpeg', 'jpg', 'gif', 'png'];
            if (!in_array($fileExtension, $allow_ext)) {
                echo "<script>window.parent.CKEDITOR.tools.callFunction(" . $CKEditorFuncNum . ", '', '파일은 jpeg,jpg,gif,png 형태만 가능합니다.')</script>";
                return false;
            }

            $encName = Crypt::encryptString($fileName);
            $request->file('upload')->move(public_path('storage/ckeditorImages'), $fileName . "." . $fileExtension);
            $url = "/public/storage/ckeditorImages/" . $fileName . "." . $fileExtension;
            $msg = '업로드 성공!';
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo "<script>window.parent.CKEDITOR.tools.callFunction(" . $CKEditorFuncNum . ", '" . $url . "', '" . $msg . "')</script>";
            return false;

        }

        echo "<script>window.parent.CKEDITOR.tools.callFunction(" . $CKEditorFuncNum . ", '', '파일이 존재하지 않습니다.')</script>";

    }
}

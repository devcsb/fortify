@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('글 수정') }}</div>
                    <form action="{{ route('qnas.update',$qna->id) }}" method="post" name="writeForm"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table id="write" class="min-w-full divide-y divide-gray-200">
                            <tr>
                                <td class="td_left"><label for="author">작성자</label></td>
                                <td class="td_right"><input name="author" type="text" id="author" value="{{$qna->author}}">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_left"><label for="password">비밀번호</label></td>
                                <td class="td_right"><input name="password" type="password" id="password" value="">
                                </td>
                            </tr>
                            <tr>
                                <td class="td_left"><label for="secret_check">비밀글 설정</label></td>
                                <td class="td_right">
                                    <input name="secret_check" type="hidden" id="secret_check" value="0">
                                    <input name="secret_check" type="checkbox" id="secret_check"
                                           value="1" checked>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_left"><label for="title">제 목</label></td>
                                <td class="td_right"><input name="title" type="text" id="title" required="required" value="{{$qna->title}}"
                                                            style="width: 665px"></td>
                            </tr>
                            <tr>
                                <td class="td_left"><label for="content">내 용</label></td>
                                <td><textarea id="content" class="ckeditor" name="content" cols="80" rows="15"
                                              required="required"
                                              value="{{ $qna->content }}"></textarea></td>
                            </tr>

                        </table>
                        <section id="commandCell">
                            <input type="submit" value="등록" style="float: right; margin-right: 10px;">
                        </section>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('ckeditor.imgUpload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection

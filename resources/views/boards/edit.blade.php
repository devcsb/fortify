@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('글 수정 ') }}</div>

                    <form action="{{ route('boards.update', $board->id) }}" method="post" name="updateForm"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table id="write" class="min-w-full divide-y divide-gray-200">
                            <tr>
                                <td class="td_left"><label for="name">작성자<input name="name" type="hidden" id="name"
                                                                                value="{{ $board->name }}"></label></td>
                                <td class="td_right">{{ $board->name }}</td>
                                <input name="email" type="hidden" id="email" value="{{ $board->email }}">
                            </tr>
                            <tr>
                                <td class="td_left"><label for="title">제 목</label></td>
                                <td class="td_right"><input name="title" type="text" id="title" required="required"
                                                            value="{{ $errors->has('title') ? old('title') : $board->title }}"
                                                            style="width: 665px"></td>
                            </tr>
                            <tr>
                                <td class="td_left"><label for="content">내 용</label></td>
                                <td><textarea id="content" class="ckeditor" name="content" cols="80" rows="15"
                                              required="required">{{ $errors->has('content') ? old('content') : $board->content }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_left"><label for="file">파일 첨부</label></td>
                                <td class="td_right"><input type="file" name="file[]" multiple="multiple"/></td>
                            </tr>
                            @foreach($board->files as $file)
                                <tr>
                                    <td class="td_left"></td>
                                    <td class="td_right">
                                        {{ $file->file_name }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="td_left"></td>
                                @if (isset($board->files[0]->file_path))
                                    <td class="td_right">첨부파일 삭제하기<input type="checkbox" name="file_remove"
                                                                         value="remove"></td>
                                @endif
                            </tr>
                        </table>
                        <section id="commandCell">
                            <input type="reset" value="다시쓰기" style="float: right; margin-right: 10px;"/><input
                                type="submit" value="저장" style="float: right; margin-right: 10px;">
                        </section>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{route('ckeditor.imgUpload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endsection

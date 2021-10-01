@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('글 수정 ') }}</div>


                <form action="{{ route('boards.update', $board->id) }}" method="post" name="updateForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <table id ="write" class="min-w-full divide-y divide-gray-200">
                        <tr>
                            <td class="td_left"><label for="name">작성자<input name="name" type="hidden" id="name" value="{{ $board->name }}"></label></td>
                            <td class="td_right">{{ $board->name }}</td>
                            <input name="email" type="hidden" id="email" value="{{ $board->email }}">
                        </tr>
                        <tr>
                            <td class="td_left"><label for="title">제 목</label></td>
                            <td class="td_right"><input name="title" type="text" id="title" required="required"  value="{{ $errors->has('title') ? old('title') : $board->title }}"style="width: 665px"></td>
                        </tr>
                        <tr>
                            <td class="td_left"><label for="content">내 용</label></td>
                            <td><textarea id="content" name="content" cols="80" rows="15" required="required">{{ $errors->has('content') ? old('content') : $board->content }}</textarea></td>
                        </tr>
                        <tr>
                            <td class="td_left"><label for="file">파일 첨부</label></td>
                            <td class="td_right"><input type="file" name="file"/></td>
                        </tr>
                        <tr>
                            <td class="td_left"></td>
                            @if (isset($board->file_path))
                            <td class="td_right"><label for="file">기존 첨부된 파일:{{ $board->file_name }}</label></td>
                            @endif 
                        </tr>
                        
                        <tr>
                            <td class="td_left"></td>
                            @if (isset($board->file_path))
                            <td class="td_right">첨부파일 삭제하기<input type="checkbox" name="file_remove" value="remove"></td>
                            @endif
                        </tr>
                    </table>
                    <section id="commandCell">
                       <input type="reset" value="다시쓰기" style="float: right; margin-right: 10px;" /><input type="submit" value="저장" style="float: right; margin-right: 10px;">
                    </section>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
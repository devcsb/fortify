@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('글 작성 ') }}</div>


                <form action="{{ route('boards.store') }}" method="post" name="writeForm" enctype="multipart/form-data">
                    @csrf
                    <table id ="write" class="min-w-full divide-y divide-gray-200">
                        <tr>
                            <td class="td_left"><label for="name">작성자</label></td>
                            <td class="td_right">{{ Auth::name() }}<input name="name" type="hidden" id="name" value="{{ Auth::name() }}"></td>
                            <input name="email" type="hidden" id="email" value="{{ Auth::email() }}">
                        </tr>
                        <tr>
                            <td class="td_left"><label for="title">제 목</label></td>
                            <td class="td_right"><input name="title" type="text" id="title" required="required" style="width: 665px"></td>
                        </tr>
                        <tr>
                            <td class="td_left"><label for="content">내 용</label></td>
                            <td><textarea id="content" name="content" cols="80" rows="15" required="required" value="{{ old('content','') }}"></textarea></td>
                        </tr>
                        <tr>
                            <td class="td_left"><label for="file">파일 첨부</label></td>
                            <td class="td_right"><input type="file" name="file"/></td>
                        </tr>
                    </table>
                    <section id="commandCell">
                       <input type="reset" value="다시쓰기" style="float: right; margin-right: 10px;" /><input type="submit" value="등록" style="float: right; margin-right: 10px;">
                    </section>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('비밀번호 입력 ') }}</div>
{{--                    @if($caller=='show')--}}
{{--                        <form action="{{ route('qnas.checkPw', ['qna'=> $qnaId, 'caller'=>$caller ])}}" method="post"--}}
{{--                              name="writeForm">--}}
{{--                            @method('DELETE')--}}
{{--                            @endif--}}
                            <form action="{{ route('qnas.checkPw', ['qna'=> $qnaId, 'caller'=>$caller ])}}"
                                  method="post"
                                  name="writeForm">
                                @csrf
                                <table id="write" class="min-w-full divide-y divide-gray-200">
                                    <tr>
                                        <td class="td_left"><label for="password">비밀번호</label></td>
                                        <td class="td_right"><input name="password" type="text" id="password" value="">
                                        </td>
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
@endsection

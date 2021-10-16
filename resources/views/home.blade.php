@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ auth()->user()->name."님 환영합니다!"}}</div>

                    <div class="card-body">
                        @if ( session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ auth()->user()->name."님은 현재 로그인 상태입니다!" }}

                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{ route('boards.index') }}" class="btn btn-xs btn-info pull-right">글 목록</a>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-xs btn-info pull-right">회원정보수정</a>


                </div>
                <a href="{{ route('profile.password.edit') }}" class="btn btn-xs btn-info"
                   style="float:right; margin-top:5px;">비밀번호 변경</a>
            </div>
        </div>
    </div>
@endsection

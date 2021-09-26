@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{Auth::name()."님 환영합니다!"}}</div>
                {{--1. $session = Auth::name() 처럼 변수명 선언하는 방법
                    2. Auth::name() 만 호출해서 바로  출력하는 방법. 어떤 것이 관례에 더 맞는? 재사용여부에 따라 다른지?
                    and
                    auth()->user()->id ; 처럼 헬퍼함수로 가져오는 방법과 퍼사드로 가져오는 방법 차이? 어느 상황에서 어떤 것이 더 올바른지?
                    --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ Auth::name()."님은 현재 로그인 상태입니다!" }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

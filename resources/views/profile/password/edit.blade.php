@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('비밀번호 변경 폼') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')
                        {{-- @dd(session('status')) --}}
                        @if(session('status')== "password-updated")
                        {{-- "password-updated  상태값을 어떻게 보는지--}}
                        <div class="alert alert-success">
                            비밀번호 변경이 정상적으로 처리되었습니다!
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('현재 비밀번호') }}</label>

                            <div class="col-md-6">
                                <input id="current_password" type="text" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" name="current_password" required autofocus>

                                @error('current_password','updatePassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __(' 새 비밀번호') }}</label>
                            
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password" required autocomplete="new-password">
                                
                                @error('password', 'updatePassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('새 비밀번호 확인') }}</label>
                            
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('비밀번호 변경') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('회원수정 폼') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user-profile-information.update') }}">
                        @csrf
                        @method('PUT')
                        {{-- @dd(session('status')) --}}
                        @if(session('status')== "profile-information-updated")
                        {{-- "profile-information-updated" 값이 어디서 나온건지--}}
                        <div class="alert alert-success">
                            회원정보 변경이 정상적으로 처리되었습니다!
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('이름') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror" name="name" value="{{ old('name') ?? auth()->user()->name }}" required autocomplete="name" autofocus>

                                @error('name', 'updateProfileInformation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        
                        
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('이메일 주소') }}</label>
                
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror" name="email" value="{{ old('email') ?? auth()->user()->email }}" required autocomplete="email" readonly>
                
                                @error('email', 'updateProfileInformation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('성별') }}</label>
                
                            <div class="col-md-6">
                                <input type="radio" id="gender" name="gender" value="male"  @error('gender', 'updateProfileInformation') is-invalid @enderror>남&nbsp;&nbsp;
                                <input type="radio" id="gender" name="gender" value="female"  @error('gender', 'updateProfileInformation') is-invalid @enderror>여
                
                                @error('gender', 'updateProfileInformation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('휴대전화 번호') }}</label>
                
                            <div class="col-md-6">
                                <input id="phone" name="phone" type="text" class="form-control @error('phone', 'updateProfileInformation') is-invalid @enderror" value="{{ old('phone') }}" required autocomplete="phone">
                
                                @error('phone', 'updateProfileInformation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('회원정보 수정') }}
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

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('글 목록 ') }}</div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 80%">
                          제목
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          작성자
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          작성시간
                        </th>
                      </tr>
                    </thead>
                        <tbody>
                            @foreach ($boards as $board)
                            <tr>
                                <td style="width: 80%"><a href="{{ route('boards.show', $board->id) }}">{{ $board->title }}</a></td>
                                <td>{{ $board->name }}</td>
                                <td></td>
                              </tr>
                              @endforeach
                        </tbody>
                      
                    
                    
                  </table>
                <div class="card-body">
                    
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('로그인 상태입니다!') }} --}}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
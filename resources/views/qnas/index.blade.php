@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('qna 목록 ') }}</div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                글번호
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                style="width: 60%">
                                제목
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                작성자
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                작성시간
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--                            게시글 시작--}}
                        @foreach($qnas as $qna)
                            <tr>
                                <td>{{ $qna->id }}</td>
                                <td style="width: 60%">
                                    @if($qna->secret_flag ==1)
                                        비밀
                                    @endif
                                    @if($qna->indent !=0)
                                        ↳
                                        @for($i =0; $i <= $qna->indent * 2; $i++)
                                            &nbsp;
                                        @endfor
                                    @endif
                                    <a href="{{ route('qnas.show', $qna->id) }}">{{ $qna->title }}</a></td>
                                <td>{{ $qna->author }}</td>
                                <td>{{ $qna->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('qnas.index') }}" style="float: right; margin: 15px;">
                    <button>목록</button>
                </a>
                <a href="{{ route('qnas.create') }}" style="float: right; margin-top: 15px;">
                    <button>글쓰기</button>
                </a>
                {{--                <div class="col-md-4" style="margin:10px">--}}
                {{--                    {{ $boards->withQueryString()->links('vendor.pagination.custom') }}</div>--}}

            </div>
            <form action="{{ route('qnas.index') }}" method="GET" role="search" class="col-md-4"
                  style="margin:10px; float: right;">

                {{--                <input type="text" class="form-control mr-2" name="search" placeholder="검색할 내용을 입력하세요"--}}
                {{--                       value="{{ $search = request()->get('search') }}" id="search" style="float:right">--}}
                <div class="input-group">
                    <span class="input-group-btn mr-5 mt-1">
                        <button type="submit" title="Search projects">
                            <span class="fas fa-search">검색</span>
                        </button>
                    </span>

                </div>
            </form>
        </div>
    </div>

@endsection

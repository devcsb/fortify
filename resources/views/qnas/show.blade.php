@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('글 내용 ') }}</div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                style="width: 80%">
                                제목: {{ $qna->title }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                작성자: {{ $qna->name }}
                            </th>
                        </tr>
                        </thead>
                    </table>
                    내용: {!! $qna->content !!}
                    <div style="margin-top:50px">
                    </div>
                    <div id="file_view">
                    </div>
                </div>
                <a href="{{ route('qnas.index') }}" style="float: right; margin-top: 15px;">
                    <button>글 목록</button>
                </a>
                <form action="{{ route('qnas.destroy', $qna->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button style="float: right; margin: 15px;">글 삭제</button>
                </form>
                <a href="{{ route('qnas.edit', $qna->id) }}" style="float: right; margin-top: 15px;">
                    <button>글
                        수정
                    </button>
                </a>
                <a href="{{ route('qnas.create_reply',['qna'=>$qna->id])}}" style="float: right; margin-top: 15px;">
                    <button>답글 작성
                    </button>

            </div>
        </div>
    </div>
@endsection

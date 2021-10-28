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
                                제목: {{ $board->title }}
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                작성자: {{ $board->name }}
                            </th>
                        </tr>
                        </thead>
                    </table>
                    내용: {!! $board->content !!}
                    <div style="margin-top:50px">
                        @foreach($board->files as $file)
                            <img src="{{ asset('storage/' . $file->file_path) }}" alt="첨부파일" title="첨부파일"
                                 style="width: 50%; height: 50%">
                        @endforeach
                    </div>
                    <div id="file_view">
                        @foreach($board->files as $file)
                            첨부파일: <a href="{{ Storage::url($file->file_path) }}"
                                     download>{{ Storage::url($file->file_path) }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('boards.index') }}" style="float: right; margin-top: 15px;">
                    <button>글 목록</button>
                </a>
                @can('delete', $board)
                    <form action="{{ route('boards.destroy', $board->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button style="float: right; margin: 15px;">글 삭제</button>
                    </form>
                @endcan
                {{-- <a href="{{ route('boards.destroy',$board->id) }}" style="float: right; margin: 15px;"><button>글 삭제</button></a> --}}
                {{-- delete 리퀘스트는 RESTful 원칙에 의거해서 그냥 href만 써서 get방식으로 보내면 작동안됨. post로 보내는 폼 안에서 @method('DELETE') 지시어로 delete요청으로 바꿔서 보내야 한다. --}}
                @can('delete', $board)
                    <a href="{{ route('boards.edit', $board->id) }}" style="float: right; margin-top: 15px;">
                        <button>글
                            수정
                        </button>
                    </a>
                @endcan


            </div>
        </div>
    </div>
@endsection

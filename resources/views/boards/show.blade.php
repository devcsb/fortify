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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 80%">
                          제목: {{ $board->title }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          작성자: {{ $board->name }}
                        </th>
                      </tr>
                    </thead>
                  </table>
                  내용: {{ $board->content }}
                  <div style="margin-top:50px">
                  <img src="{{asset('storage/'.$board->file_path)}}" alt="1" style="width: 50%; height: 50%">
                  </div>
                  <div id="file_view">
                    첨부파일: <a href="{{ Storage::url($board->file_path) }}" download>{{ Storage::url($board->file_path) }}</a>
                  </div>
                </div>
                <a href="{{ route('boards.index')}}" style="float: right; margin-top: 15px;"><button>글 목록</button></a>
                <form action="{{ route('boards.destroy',$board->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button style="float: right; margin: 15px;">글 삭제</button>
              </form>
                {{-- <a href="{{ route('boards.destroy',$board->id) }}" style="float: right; margin: 15px;"><button>글 삭제</button></a> --}}
                {{-- delete 리퀘스트는 그냥 href로 하면 안먹힘. post로 보내거나, post로 보내는 폼 안에서 @method('DELETE') 지시어로 delete요청으로 바꿔서 보내야 한다. --}}
                <a href="{{ route('boards.edit',$board->id) }}" style="float: right; margin-top: 15px;"><button>글 수정</button></a>

        </div>
    </div>
</div>
@endsection
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
                            @can('manage-boards')
                                <th width="50px"><input type="checkbox" id="chkAll"></th>
                            @endcan
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
                        @foreach ($notices as $notice)
                            <tr>
                                <td style="font-weight: bold">{{ '공지' }}</td>
                                <td style="width: 60%"><a
                                        href="{{ route('boards.show', $notice->id) }}">{{ $notice->title }}</a></td>
                                <td>{{ $notice->name }}</td>
                                <td>{{ substr($notice->created_at, 5, 5) }}</td>
                            </tr>
                        @endforeach

                        {{-- 1페이지에만 공지 나오는 방식 --}}
                        @foreach ($boards as $board)
                            <tr>
                                @can('manage-boards')
                                    <td><input type="checkbox" class="del_chk" data-id="{{ $board->id }}">
                                    </td>
                                @endcan
                                {{-- @if ($board->notice_flag == 'Y')
                            <td style="font-weight: bold" >{{ "공지" }}</td>
                          @else --}}
                                <td>{{ $board->id }}</td>
                                {{-- @endif --}}
                                <td style="width: 60%">
                                    <a href="{{ route('boards.show', $board->id) }}">{{ $board->title }}</a></td>
                                <td>{{ $board->name }}</td>
                                <td>{{ substr($board->created_at, 5, 5) }}</td>
                                @can('manage-boards')
                                    <td>
                                        <button class="btn btn-danger" id="row_delete{{ $board->id }}"
                                                data-url="{{ route('admin.delete') }}" data-tr="tr_{{ $board->id }}"
                                                onclick="row_delete({{ $board->id }})">삭제
                                        </button>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <a href="{{ route('boards.index') }}" style="float: right; margin: 15px;">
                    <button>목록</button>
                </a>
                <a href="{{ route('boards.create') }}" style="float: right; margin-top: 15px;">
                    <button>글쓰기</button>
                </a>
                @can('manage-boards')
                    <button class="btn btn-danger" id="delete_all" data-url="{{ route('admin.deleteSelected') }}">삭제
                    </button>
                @endcan
                <div class="col-md-4" style="margin:10px">
                    {{ $boards->withQueryString()->links('vendor.pagination.custom') }}</div>

            </div>
            <form action="{{ route('boards.index') }}" method="GET" role="search" class="col-md-4"
                  style="margin:10px; float: right;">

                <input type="text" class="form-control mr-2" name="search" placeholder="검색할 내용을 입력하세요"
                       value="{{ $search = request()->get('search') }}" id="search" style="float:right">
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
    <script>
        function row_delete(id) {
            var check = confirm("정말 삭제하시겠습니까?");
            if (check == true) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.delete') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        _method: 'DELETE',
                    },
                    //라라벨은 delete 메소드를 수행할 때 post요청을 매개변수로 사용하므로, 이런 식으로 가운데서 method를 변경시켜줘야한다.
                    //onclick통한 함수 호출 시에는 반드시 이렇게 해야되는 듯 하나, $function(e) 안에서 선택자 통한 이벤트 감지 방식에서는 곧바로 method 타입
                    //에 DELETE를 적어도 작동한다.
                    success: function (data) {
                        if (data['success']) {
                            // $("#" + data['tr']).slideUp("slow");
                            $("#row_delete" + id).parents("tr").remove();
                            alert(data['success']);
                        } else if (data['error']) {
                            alert(data['error']);
                        } else {
                            alert('Whoops Something went wrong!!');
                        }
                    },
                    error: function (data) {
                        alert(data.responseText);
                    }
                });


                return false;
            }


        }

        $(function (e) {
            $("#chkAll").click(function () {
                $(".del_chk").prop('checked', $(this).prop('checked'));
            });

            $("#delete_all").click(function (e) {
                var allVals = [];
                $(".del_chk:checked").each(function () {
                    allVals.push($(this).attr('data-id'));
                });


                if (allVals.length <= 0) {
                    alert("삭제할 게시글을 선택하세요");
                } else {

                    var check = confirm("정말 삭제하시겠습니까?");
                    if (check == true) {

                        var join_selected_values = allVals.join(",");
                        // alert($(this).data('url'));
                        $.ajax({
                            url: $(this).data('url'),
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: 'ids=' + join_selected_values,
                            success: function (data) {
                                if (data['success']) {
                                    $(".del_chk:checked").each(function () {
                                        $(this).parents("tr").remove();
                                    });
                                    alert(data['success']);
                                } else if (data['error']) {
                                    alert(data['error']);
                                } else {
                                    alert('알 수 없는 에러');
                                }
                            },
                            error: function (data) {
                                alert(data.responseText);
                            }

                        }); //ajax끝

                        // $.each(allVals, function(index, value) { //함수 용도 파악하지 못하였음.
                        //     $('table tr').filter("[data-row-id='" + value + "']").remove();
                        // });

                    } //확인메시지 끝
                } //게시글 선택 조건문 끝
            }); //버튼 event 끝
        });
    </script>
@endsection

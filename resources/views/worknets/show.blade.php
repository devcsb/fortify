@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('채용정보 상세 ') }}</div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 80%">
                           구인 제목: {{ $worknets['wantedInfo']['wantedTitle'] }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          회사명: {{ $worknets['corpInfo']['corpNm'] }}
                        </th>
                      </tr>
                    </thead>
                  </table>

                  <p>직무 내용: {{ $worknets['wantedInfo']['jobCont'] }}</p>
                  <p><a href="{{ url('https://www.work.go.kr/empInfo/empInfoSrch/detail/empDetailAuthView.do?searchInfoType=VALIDATION&callPage=detail&wantedAuthNo='.$authNum.'&rtnTarget=list1#none') }}" download>worknet 원문</a>

              </div>

              <table style="border-style:solid">
                <colgroup>
              <col style="width:23%;">
              <col style="width:13%;">
              <col style="width:17%;">
              <col style="width:12%;">
              <col style="width:15%;">
                </colgroup>
                <thead>
                  <tr>
                    <th scope="col">경력조건</th>
                    <th scope="col">학력</th>
                    <th scope="col">고용형태</th>
                    <th scope="col">모집인원</th>
                    <th scope="col">근무예정지</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>

                      {{ $worknets['wantedInfo']['enterTpNm'] }}</td>
                    <td>
                      {{ $worknets['wantedInfo']['eduNm'] }}
                    </td>
                    <td>
                      {{ $worknets['wantedInfo']['empTpNm'] }}
                    </td>
                    <td>
                      {{ $worknets['wantedInfo']['collectPsncnt'] }}
                    </td>
                    <td>
                      {{ $worknets['wantedInfo']['workRegion'] }}
                    </td>
                  </tr>
                </tbody>
              </table>

                <a href="{{ route('worknets.index')}}" style="float: right; margin-top: 15px;"><button>글 목록</button></a>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          회사명
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 45%">
                          채용공고명
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          연봉
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          근무지
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          등록일
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          마감일
                        </th>
                      </tr>
                    </thead>
                        <tbody>
                          {{-- 코드 개선 필요 --}}
                          {{ $message }}
                          @if(@isset($worknets))
                          @foreach ($worknets as $worknet)
                          @if($total ==1)
                          {{ $worknet = $worknets }}
                          @endif
                            <tr>
                              <td>{{ $worknet['company'] }}</td>
                                <td style="width: 45%"><a href="{{ route('worknets.show', $worknet['wantedAuthNo']) }}">{{ $worknet['title'] }}</a></td>
                                <td>{{ $worknet['sal'] }}</td>
                                <td>{{ $worknet['basicAddr'] }}</td>
                                <td>{{ substr($worknet['regDt'],3,5) }}</td>
                                <td>{{ substr($worknet['closeDt'],3,5) }}</td>
                                {{-- <td>{{ $worknet['wantedMobileInfoUrl'] }}</td> --}}
                              </tr>
                              @if($total ==1)
                              @break 
                              @endif
                              @endforeach
                              @endif
                              

                        </tbody>
                      </table>
                    
                    <a href="{{ route('worknets.index') }}" style="float: right; margin: 15px;"><button>목록</button></a>
                    @if(@isset($worknets)) 
                    <div class="col-md-4" style="margin:10px">{{ $worknets->withQueryString()->links('vendor.pagination.custom') }}</div>
                    @endif
                  <form action="{{ route('worknets.index') }}" method="GET" role="search" class="col-md-4" style="margin:10px; float: right;">
                    <input type="text" class="form-control mr-2" name="search" placeholder="검색할 내용을 입력하세요" value="{{ $search = request()->get('search') }}"id="search" style="float:right">
                    <div class="input-group">
                        <span class="input-group-btn mr-5 mt-1">
                            <button type="submit" title="Search projects">
                                <span class="fas fa-search">검색</span>
                            </button>
                        </span>
                        
                    </div>
                </form>
                
@endsection
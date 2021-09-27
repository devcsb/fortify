@if ($paginator->hasPages())
<div style="width:600px; margin-left:100px">
    <ul class="pager" style="list-style: none">
       
        @if ($paginator->onFirstPage())
            <li class="disabled" style="float: left; margin: 3px;"><span>← 이전</span></li>
        @else
            <li style="float: left"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">← 이전 </a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled" style="float: left"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li style="float: left; margin: 3px;" class="active my-active"><span>{{ $page }}</span></li>
                    @else
                        <li style="float: left; margin: 3px;"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li style= "margin: 3px"><a href="{{ $paginator->nextPageUrl() }}" rel="next">다음 →</a></li>
        @else
            <li class="disabled" style="margin: 3px"><span>다음 →</span></li>
        @endif
    </ul>
</div>
@endif 
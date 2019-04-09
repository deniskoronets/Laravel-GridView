@if (strtoupper($method) == 'GET')
    <a href="{{ $url }}">{!! $content !!}</a>
@else
    <form action="{{ $url }}" method="{{ $method }}">
        @csrf
        <a href="{{ $url }}" onclick="this.parentNode.submit()">{!! $content !!}</a>
    </form>
@endif
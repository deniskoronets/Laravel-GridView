@if (strtoupper($method) == 'GET')
    <a href="{{ $url }}">{!! $content !!}</a>
@else
    <form action="{{ $url }}" method="POST" style="display: inline">
        @csrf
        @method($method)
        <a href="{{ $url }}"
           onclick="if (confirm('Are you sure you want to perform this action?')) { this.parentNode.submit() }; return false;"
        >{!! $content !!}</a>
    </form>
@endif
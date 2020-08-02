@foreach ($items as $key => $value)
    @if (is_array($value))
        @include('woo_gridview::_grid-form-additional-recursive', [
            'items' => $value,
            'prefixKey' => !empty($prefixKey) ? '[' . $key . ']' : $key,
        ])
    @else
        <input type="hidden" name="{{ !empty($prefixKey) ? $prefixKey . '[' . $key . ']' : $key }}" value="{{ $value }}">
    @endif
@endforeach

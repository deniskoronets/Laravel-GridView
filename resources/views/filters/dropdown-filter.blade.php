<select class="{{ $cssClass }}" name="filters[{{ $name }}]" class="filter-input">
    <option value=""></option>
    @foreach ($items as $k => $v)
        <option value="{{ $k }}">{{ $v }}</option>
    @endforeach
</select>

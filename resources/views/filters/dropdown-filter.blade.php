<select class="{{ $cssClass }} filter-input" name="{{ $name }}" onchange="gridViewFilter{{ $grid->getId() }}(event)">
    <option value=""></option>
    @foreach ($items as $k => $v)
        <option value="{{ $k }}" @if ($k == $value) selected @endif>{{ $v }}</option>
    @endforeach
</select>

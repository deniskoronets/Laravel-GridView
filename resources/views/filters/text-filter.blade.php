<input type="text"
       class="{{ $cssClass }} filter-input"
       value="{{ $value }}"
       name="{{ $name }}"
       onchange="gridViewFilter{{ $grid->getId() }}(event)"
>

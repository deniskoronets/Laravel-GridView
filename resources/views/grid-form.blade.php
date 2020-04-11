@php
    /**
    * @var \Woo\GridView\GridView $grid
    **/
@endphp
<form class="grid-form" action="" method="GET" style="display: none;" ref="gridForm">
    <input type="hidden" name="{{ $grid->getId() == 0 ? 'sort' : 'grid[' . $grid->getId() . '][sort]' }}" :value="sortColumn">
    <input type="hidden" name="{{ $grid->getId() == 0 ? 'order' : 'grid[' . $grid->getId() . '][order]' }}" :value="sortDesc ? 'DESC' : 'ASC'">

    @if ($grid->showFilters)
        @foreach ($grid->columns as $column)
            @if ($column->filter)
                <input type="hidden"
                       name="{{ $grid->getId() == 0 ? 'filters' : 'grid[' . $grid->getId() . '][filters]' }}[{{ $column->filter->name }}]"
                       :value="filters['{{ $column->filter->name }}']"
                       v-if="filters['{{ $column->filter->name }}']"
                >
            @endif
        @endforeach
    @endif
</form>

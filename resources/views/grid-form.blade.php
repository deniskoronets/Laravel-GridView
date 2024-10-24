@php
    /**
    * @var \Woo\GridView\GridView $grid
    **/
@endphp
<form class="grid-form" action="" method="GET" style="display: none;" ref="gridForm">
    <input type="submit" />
    <input type="hidden" class="sort" name="{{ $grid->getId() == 0 ? 'sort' : 'grid[' . $grid->getId() . '][sort]' }}">
    <input type="hidden" class="order" name="{{ $grid->getId() == 0 ? 'order' : 'grid[' . $grid->getId() . '][order]' }}">

    @if (!empty($grid->additionalRequestParams))
        @include('woo_gridview::_grid-form-additional-recursive', ['items' => $grid->additionalRequestParams, 'prefixKey' => ''])
    @endif

    @if ($grid->showFilters)
        @foreach ($grid->columns as $column)
            @if ($column->filter)
                <input type="hidden"
                       name="{{ $grid->getId() == 0 ? 'filters' : 'grid[' . $grid->getId() . '][filters]' }}[{{ $column->filter->name }}]"
                >
            @endif
        @endforeach
    @endif
</form>

@php
/**
* @var \Woo\GridView\GridView $grid
**/
@endphp

<div class="grid-view-container"
     id="grid-{{ $grid->getId() }}"
     data-filters='@json($filters)'
     data-sort-column="{{ $grid->getRequest()->sortColumn }}"
     data-sort-order="{{ $grid->getRequest()->sortOrder }}"
>
    @include('woo_gridview::grid-form')

    <table {!! $grid->compileTableHtmlOptions() !!}>
        <thead>
            <tr>
                @foreach ($grid->columns as $column)
                    <th {!! $column->compileHeaderHtmlOptions() !!}>
                        <a href="#" @if ($column->sortable && is_scalar($column->value)) v-on:click="sort('{{ $column->value }}')" @endif>{{ $column->title }}</a>

                        @if ($column->sortable)
                            @if ($grid->getRequest()->sortColumn == $column->value)
                                <span class="sort-{{ strtolower($grid->getRequest()->sortOrder) }}"></span>
                            @endif
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if ($grid->showFilters)
                <tr>
                    @foreach ($grid->columns as $column)
                        <td>
                            @if ($column->filter)
                               {!! $column->filter->render($grid) !!}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endif

            @forelse ($grid->getPagination()->items() as $row)
                <tr>
                    @foreach ($grid->columns as $column)
                        <td {!! $column->compileContentHtmlOptions(['model' => $row]) !!}>
                            {!! $column->renderValue($row) !!}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($grid->columns) }}" class="text-center">
                        No data to display
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($grid->rowsPerPage != 0)
            <caption>
                {!! $grid->getPagination()->render('woo_gridview::grid-pagination', ['gridId' => $grid->getId()]) !!}
            </caption>
        @endif
    </table>
</div>

<script src="/vendor/grid-view/grid-view.bundle.js"></script>
<script>
    window.GridViewShared = @json([]);
    new WooGridView('#grid-{{ $grid->getId() }}');
</script>
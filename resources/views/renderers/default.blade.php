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

    <form class="d-none grid-form" action="" method="GET">
        <input type="hidden" name="sort" v-model="sortColumn">
        <input type="hidden" name="order" v-model="sortOrder">

        @if ($grid->showFilters)
            @foreach ($grid->columns as $column)
                @if ($column->filter)
                    <input type="hidden" name="filters[{{ $column->filter->name }}]" v-model="filters['{{ $column->filter->name }}']" v-if="filters['{{ $column->filter->name }}']">
                @endif
            @endforeach
        @endif
    </form>

    <table {!! $grid->compileTableHtmlOptions() !!}>
        <thead>
            <tr>
                @foreach ($grid->columns as $column)
                    <th {!! $column->compileHeaderHtmlOptions() !!}>
                        <a href="#" v-on:click="sort('{{ $column->value }}')">{{ $column->title }}</a>

                        @if ($column instanceof \Woo\GridView\Columns\AttributeColumn)
                            @if ($grid->getRequest()->sortColumn == $column->value)
                                @if ($grid->getRequest()->sortOrder == 'ASC')
                                    ˅
                                @else
                                    ˄
                                @endif
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
                        <td {!! $column->compileContentHtmlOptions(['model' => $row]) !!}>{!! $column->renderValue($row) !!}</td>
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
                {!! $grid->getPagination()->render() !!}
            </caption>
        @endif
    </table>
</div>

<script src="/vendor/grid-view/grid-view.bundle.js"></script>
<script>
    window.GridViewShared = @json([]);
    new WooGridView('#grid-{{ $grid->getId() }}');
</script>
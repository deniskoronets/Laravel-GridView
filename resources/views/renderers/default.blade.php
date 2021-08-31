@php
/**
* @var \Woo\GridView\GridView $grid
**/
    use Woo\GridView\GridView;$paginator = $grid->getPagination();
    $thisStart = 1 + ($paginator->currentPage() - 1) * $paginator->perPage();
    $thisEnd = $paginator->currentPage() * $paginator->perPage()
@endphp

<div class="grid-view-container">
    <grid-view
        inline-template
        id="grid-{{ $grid->getId() }}"
        :origin-filters='@json($filters)'
        sort-column="{{ $grid->getRequest()->sortColumn }}"
        sort-order="{{ $grid->getRequest()->sortOrder }}"
    >
        <div>
            @include('woo_gridview::grid-form')
            @if ($paginator->hasPages())
                <div class="summary">Displaying {{$thisStart}}-{{$thisEnd}} of {{$paginator->total()}} results.</div>
            @endif
            <table {!! $grid->compileTableHtmlOptions() !!}>
                <thead>
                    <tr>
                        @foreach ($grid->columns as $column)
                            <th {!! $column->compileHeaderHtmlOptions() !!}>
                                <a href="#" @if ($column->getSortableName() !== false) v-on:click="sort('{{ $column->getSortableName() }}')" @endif>{{ $column->title }}</a>

                                @if ($column->sortable)
                                    @if ($grid->getRequest()->sortColumn == $column->value)
                                        <span class="sort-{{ strtolower($grid->getRequest()->sortOrder) }}"></span>
                                    @endif
                                @endif
                            </th>
                        @endforeach
                    </tr>
                    @if ($grid->showFilters)
                        <tr>
                            @foreach ($grid->columns as $column)
                                <th>
                                    @if ($column->filter)
                                        {!! $column->filter->render($grid) !!}
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    @endif
                </thead>
                <tbody>
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
    </grid-view>
</div>

@if ($grid->standaloneVue)
<script src="{{ asset('vendor/woo_gridview/grid-view.bundle.js')  }}"></script>
<script>
    window.GridViewShared = @json([]);
    new WooGridView('#grid-{{ $grid->getId() }}');
</script>
@endif

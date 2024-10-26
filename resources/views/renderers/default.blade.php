@php
/**
* @var \Woo\GridView\GridView $grid
**/
use Woo\GridView\GridView;

$paginator = $grid->getPagination();
$thisStart = 1 + ($paginator->currentPage() - 1) * $paginator->perPage();
$thisEnd = $paginator->currentPage() * $paginator->perPage()
@endphp

<div class="grid-view-container">
    <div class="woo-grid-view"
         data-id="{{ $grid->getId() }}"
         data-sort="{{ $grid->getRequest()->sortColumn }}"
         data-order="{{ $grid->getRequest()->sortOrder }}"
    >
        @include('woo_gridview::grid-form')
        @if ($paginator->hasPages())
            <div class="summary">Displaying {{$thisStart}}-{{$thisEnd}} of {{$paginator->total()}} results.</div>
        @endif
        <table {!! $grid->compileTableHtmlOptions() !!}>
            <thead>
                <tr>
                    @foreach ($grid->columns as $column)
                        <th {!! $column->compileHeaderHtmlOptions() !!}>
                            @if ($column->getSortableName() !== false)
                                <a href="#" onclick="window.gridViewSort{{ $grid->getId() }}(event, '{{ $column->getSortableName() }}')">
                                    {{ $column->title }}
                                </a>
                            @else
                                <span>{{ $column->title }}</span>
                            @endif

                            @if ($column->getSortableName() !== false)
                                @if ($grid->getRequest()->sortColumn == $column->getSortableName())
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
</div>

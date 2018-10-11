@php
/**
* @var \Woo\GridView\Columns\BaseColumn[] $columns
* @var array|mixed $data
* @var string $tableHtmlOptions
* @var \Woo\GridView\DataProviders\DataProviderInterface $dataProvider
* @var int $perPage
* @var int $currentPage
**/
@endphp

<table {!! $tableHtmlOptions !!}>
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th {!! $column->headerHtmlOptions() !!}>{{ $column->title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                @foreach ($columns as $column)
                    <td {!! $column->contentHtmlOptions() !!}>{!! $column->renderValue($row) !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
    <caption>
        @php
        $totalPages = $dataProvider->getTotalPages($perPage)
        @endphp

        <ul class="pagination">
            @if ($currentPage > 1)
                <li class="page-item"><a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a></li>
            @endif

            @for ($i = 1; $i <= $totalPages; $i++)
            <li class="page-item @if($i == $currentPage) active @endif"><a class="page-link" href="?page={{ $i }}">{{ $i }}</a></li>
            @endfor

            @if ($currentPage < $totalPages)
                <li class="page-item"><a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a></li>
            @endif
        </ul>
    </caption>
</table>
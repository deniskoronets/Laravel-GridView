@php
    /**
    * @var \Woo\GridView\GridView $grid
    **/
@endphp
<form class="grid-form" action="" method="GET" style="display: none;" ref="gridForm">
    <input type="submit" />

    @if (!empty($grid->additionalRequestParams))
        @include('woo_gridview::_grid-form-additional-recursive', ['items' => $grid->additionalRequestParams, 'prefixKey' => ''])
    @endif
</form>

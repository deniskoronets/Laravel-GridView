const grids = Array.from(document.querySelectorAll('.woo-grid-view'));

grids.map(_grid => {
    const gridId = _grid.dataset.id;
    const grid = () => document.querySelector('.woo-grid-view[data-id="' + gridId + '"]');

    const gridForm = () => grid().querySelector('form.grid-form');
    const gridFormSort = () => grid().querySelector('input.sort');
    const gridFormOrder = () => grid().querySelector('input.order');

    gridFormSort().value = grid().dataset['sort-column'];
    gridFormOrder().value = grid().dataset['sort-order'];

    window['gridViewSort' + gridId] = function (column) {
        gridFormSort().value = column;
        gridFormOrder().value = gridFormOrder().value == 'ASC' ? 'DESC' : 'ASC';
        gridForm().submit();
    };
});

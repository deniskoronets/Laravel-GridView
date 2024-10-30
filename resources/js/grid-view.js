const grids = Array.from(document.querySelectorAll('.woo-grid-view'));

grids.map(_grid => {
    const gridId = _grid.dataset.id;
    const sort = _grid.dataset.sort;
    const order = _grid.dataset.order;

    const grid = () => document.querySelector('.woo-grid-view[data-id="' + gridId + '"]');
    const gridForm = () => grid().querySelector('form.grid-form');

    const fillFormAndSubmit = (sort, order) => {
        gridForm().insertAdjacentHTML(
            'beforeend',
            `<input type="hidden" name="grid[${gridId}][sort]" value="${sort}">`
        );

        gridForm().insertAdjacentHTML(
            'beforeend',
            `<input type="hidden" name="grid[${gridId}][order]" value="${order}">`
        );

        grid().querySelectorAll('.filter-input').forEach((input) => {
            if (input.value == '') {
                return;
            }

            gridForm().insertAdjacentHTML(
                'beforeend',
                `<input type="hidden" name="grid[${gridId}][filters][${input.getAttribute('name')}]" value="${input.value}">`
            );
        });

        gridForm().submit();
    };

    window['gridViewSort' + gridId] = function (e, column) {
        e.preventDefault();
        fillFormAndSubmit(column, column === sort ? (order === 'ASC' ? 'DESC' : 'ASC') : 'ASC');
    };

    window['gridViewFilter' + gridId] = function(e) {
        fillFormAndSubmit('', '');
    };
});

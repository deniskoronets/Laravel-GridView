import Vue from 'vue'

class WooGridView {

    constructor(selector) {

        const container = this.container = document.querySelector(selector);

        let filterTimeout = null;

        this.vm = new Vue({
            el: selector,
            runtimeCompiler: false,

            data() {
                return {
                    filters: JSON.parse(container.dataset.filters),
                    sortColumn: container.dataset.sortColumn,
                    sortOrder: container.dataset.sortOrder,
                }
            },

            methods: {
                filter() {
                    if (filterTimeout) {
                        clearTimeout(filterTimeout);
                    }

                    filterTimeout = setTimeout(() => {
                        document.querySelector(selector + ' .grid-form').submit();
                    }, 500);
                },

                sort(column) {
                    //this.
                }
            }
        });
    }
}

window.WooGridView = WooGridView;

export default WooGridView;
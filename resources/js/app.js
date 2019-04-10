import Vue from 'vue'

class WooGridView {

    constructor(selector) {
        this.selector = selector;
        this.container = document.querySelector(selector);
        this.initVue();

        require('../scss/grid.scss');
    }

    initVue() {
        let filterTimeout = null;
        const self = this;

        new Vue({
            el: this.selector,
            runtimeCompiler: false,

            data() {
                return {
                    filters: JSON.parse(self.container.dataset.filters),
                    sortColumn: self.container.dataset.sortColumn,
                    sortDesc: self.container.dataset.sortOrder === 'DESC',
                }
            },

            methods: {
                filter(skipDelay = false) {

                    if (skipDelay) {
                        this.$nextTick(() => {
                            self.sendForm();
                        });
                        return;
                    }

                    if (filterTimeout) {
                        clearTimeout(filterTimeout);
                    }

                    filterTimeout = setTimeout(() => {
                        self.sendForm();
                    }, 1000);
                },

                sort(column) {
                    this.sortColumn = column;
                    this.sortDesc = !this.sortDesc;

                    this.$nextTick(() => {
                        self.sendForm();
                    });
                }
            }
        });
    }

    sendForm() {
        document.querySelector(this.selector + ' .grid-form').submit();
    }
}

window.WooGridView = WooGridView;

export default WooGridView;
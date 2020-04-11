<script>
    export default {
        props: {
            id: String,
            originFilters: Object,
            sortColumn: String,
            sortOrder: String
        },

        data() {
            return {
                filters: Object.assign({}, this.originFilters),
                sortDesc: this.sortOrder === 'DESC',
                filterTimeout: null,
            }
        },

        methods: {
            filter(skipDelay = false) {

                if (skipDelay) {
                    this.$nextTick(() => {
                        this.sendForm();
                    });
                    return;
                }

                if (this.filterTimeout) {
                    clearTimeout(this.filterTimeout);
                }

                this.filterTimeout = setTimeout(() => {
                    this.sendForm();
                }, 1000);
            },

            sort(column) {
                this.sortColumn = column;
                this.sortDesc = !this.sortDesc;

                this.$nextTick(() => {
                    this.sendForm();
                });
            },

            sendForm() {
                this.$refs.gridForm.submit();
            }
        }
    };
</script>
<style lang="scss">
    .sort-asc, .sort-desc {
        display: inline-block;
        width: 0;
        height: 0;
        margin-bottom: 5px;

        &.sort-asc {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid #007bff;
        }

        &.sort-desc {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #007bff;
        }
    }
</style>

<template>
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h3>Informes</h3>
                <div class="ml-auto results__refresh">
                    Verbose
                </div>
            </div>

            <hr class="mt-2 mb-3" />

            {{ reports }}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'reports',

        data() {
            return {
                reports: {},
                loading: true
            }
        },

        mounted() {
            this.loadReports();
        },

        methods: {
            /* Fetch results from server */
            loadReports(full) {
                this.loading = true;

                Participa.getReports(full)
                    .then(response => {
                        this.reports = response;
                        this.loading = false;
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .results {
        &__refresh a:hover {
            text-decoration: none;
        }
    }
</style>

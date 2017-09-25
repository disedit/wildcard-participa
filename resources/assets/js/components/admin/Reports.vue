<template>
    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h3>Informes</h3>
                <div class="ml-auto">
                    <a href="#" @click.prevent="loadReports()">
                        <i class="far fa-redo" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <hr class="mt-2 mb-3" />

            <div v-if="!loading" class="report-wrapper">
                <div v-for="report in reports" class="report">
                    <div v-if="report.type == 'limit'">
                        <span class="report-date">
                            {{ report.created_at }}
                        </span>
                        <span class="report-message" v-if="report.action == 'vote'">
                            La IP <a href=""><strong>{{ report.ip }}</strong></a> ha excedit el límit de vots.
                        </span>
                        <span class="report-message" v-else>
                            La IP <a href=""><strong>{{ report.ip }}</strong></a> ha sigut bloquejada per intentar esdevinar el camp DNI massa voltes.
                            <button>Desbloqueja</button>
                        </span>
                    </div>

                    <div v-else>
                        <span class="report-date">
                            {{ report.created_at }}
                        </span>
                        <span class="report-message">
                            {{ report.report }}
                        </span>
                    </div>
                </div>
            </div>
            <div v-else class="text-center">
                <i class="far fa-spinner-third fa-spin fa-3x fa-fw mt-3"></i>
                <h4 class="mt-2">Carregant...</h4>
            </div>
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
                        this.reports = response.reports;
                        this.loading = false;
                    });
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../sass/_variables';

    .report-wrapper {
        max-height: 400px;
        overflow-y: scroll;
    }

    .report {
        padding: 1rem 0;
        border-bottom: 1px $gray-lighter solid;
    }

    .report:last-child {
        border-bottom: 0;
    }
</style>

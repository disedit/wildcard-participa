<template>
    <div class="dashboard">
        <navbar />
        <div class="container">
            <edition :edition="edition" />
            <results v-if="display_results" :results="results" />
        </div>
    </div>
</template>

<script>
    import Navbar from './admin/Navbar';
    import Edition from './admin/Edition';
    import Results from './admin/Results';

    export default {
        name: 'admin',

        components: {
            Navbar,
            Edition,
            Results
        },

        data() {
            return {
                edition: {},
                results: {},
                display_results: false
            }
        },

        created() {
            this.loadEdition();
            if(window.app.user.is_superadmin) {
                this.loadResults();
                this.display_results = true;
            }
        },

        methods: {
            /* Fetch ballot from server */
            loadEdition() {
                Participa.getBallot()
                    .then(response => {
                        this.edition = response;
                    });
            },

            /* Fetch results from server */
            loadResults() {
                Participa.getResults()
                    .then(response => {
                        this.results = response;
                    });
            }
        }
    }
</script>

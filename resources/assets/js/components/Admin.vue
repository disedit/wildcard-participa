<template>
    <div class="dashboard">
        <navbar />
        <div class="container">
            <edition :edition="edition" />
            <results />
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
                edition: {}
            }
        },

        created() {
            this.loadEdition();
        },

        methods: {
            /* Fetch ballot from server */
            loadEdition() {
                Participa.getBallot()
                    .then(response => {
                        this.edition = response;
                    });
            }
        }
    }
</script>

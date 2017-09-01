<template>
    <div class="sidebar">
        <div v-html="sidebar"></div>
    </div>
</template>

<script>
    export default {
        name: 'sidebar',

        data() {
            return {
                sidebar: '',
                lang: 'en'
            }
        },

        mounted() {
            this.loadSidebar();
            this.lang = window.BoothConfig.locale;
        },

        methods: {
            loadSidebar() {
                Participa.getSidebar(this.lang)
                    .then(response => {
                        this.sidebar = response;
                    });
            }
        }
    }
</script>

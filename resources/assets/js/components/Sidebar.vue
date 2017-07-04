<template>
    <div class="sidebar">
        <div class="sidebar__box">
            <h4>{{ $t('sidebar.current_poll') }}</h4>
            <h3>{{ edition.name }}</h3>
            <p class="sidebar__dates">{{ $t('sidebar.dates', { start_date: edition.start_date, end_date: edition.end_date }) }}</p>
            <ul v-if="docs.length > 0">
                <li v-for="doc in docs">
                    <a :href="doc[1]">{{ doc[0] }}</a>
                </li>
            </ul>
        </div>
        <div class="sidebar__box" v-if="voting_places.length > 0">
            <h4>{{ $t('sidebar.voting_places') }}</h4>
            <ul>
                <li v-for="place in voting_places">
                    {{ place[0] }}
                    {{ place[1] }}
                </li>
            </ul>
        </div>
        <div class="sidebar__box">
            <h4>{{ $t('sidebar.contact') }}</h4>
            <p v-html="$t('sidebar.contact_text', { contact_email })"></p>
        </div>

        <div v-html="edition.sidebar"></div>
    </div>
</template>

<script>
    export default {
        name: 'sidebar',

        props: {
            edition: Object,
        },

        data() {
            return {
                contact_email: window.BoothConfig.contact_email
            }
        },

        computed: {
            voting_places: function() {
                if(this.edition.hasOwnProperty('voting_places'))
                    return this.parseList(this.edition.voting_places);
            },

            docs: function() {
                if(this.edition.hasOwnProperty('docs'))
                    return this.parseList(this.edition.docs);
            }
        },

        methods: {
            parseList(list) {
                let lines = list.split('\n');
                let arrayList = [];

                lines.forEach((line) => {
                    arrayList.push(line.split(','));
                });

                return arrayList;
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

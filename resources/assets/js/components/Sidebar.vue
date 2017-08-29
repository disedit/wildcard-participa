<template>
    <div class="sidebar">
        <div class="sidebar__box">
            <h4>{{ $t('sidebar.current_poll') }}</h4>
            <h3>{{ edition.name }}</h3>
            <p class="sidebar__secondary">{{ $t('sidebar.dates', { start_date, end_date }) }}</p>
            <div v-if="docs">
                <hr />
                <ul class="sidebar__list sidebar__list--links">
                    <li>
                        <a href="/about"><i class="fa fa-info-circle"></i> {{ $t('sidebar.more_info') }}</a>
                    </li>
                    <li v-for="doc in docs">
                        <a :href="doc[1]" target="_blank">
                            <i v-if="!doc[2]" class="fa fa-file-text-o"></i>
                            <i v-else :class="'fa fa-' + doc[2]"></i>
                            {{ doc[0] }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar__box" v-if="voting_places">
            <h4>{{ $t('sidebar.voting_places') }}</h4>
            <p>{{ $t('sidebar.voting_help') }}</p>
            <hr />
            <ul class="sidebar__list">
                <li v-for="place in voting_places">
                    {{ place[0] }}
                    <span class="sidebar__secondary">{{ place[1] }}</span>
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
    import moment from 'moment';
    moment.locale(window.BoothConfig.locale);

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
            },

            start_date: function() {
                return moment(this.edition.start_date).format('LL');
            },

            end_date: function() {
                return moment(this.edition.end_date).format('LL');
            }
        },

        methods: {
            parseList(list) {
                let lines = list.split('\n');
                let arrayList = [];

                if(list.length == 0) return;

                lines.forEach((line) => {
                    arrayList.push(line.split(','));
                });

                return arrayList;
            }
        }
    }
</script>

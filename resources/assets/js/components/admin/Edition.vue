<template>
    <div class="card mt-4">
        <div class="card-block">
            <div class="row">
                <div class="col-sm">
                    <h1>{{ edition.name }}</h1>
                </div>
                <div class="col-sm text-right">
                    <div v-if="editionIsOpen" class="vote-status vote-status--open">
                        <i class="fa fa-unlock" aria-hidden="true"></i> Votació oberta
                    </div>
                    <div v-else class="vote-status vote-status--closed">
                        <i class="fa fa-lock" aria-hidden="true"></i> Votació tancada
                    </div>
                </div>
            </div>
            <hr class="mt-3" />
            <div class="row">
                <div class="col-sm-6">
                    <a href="" :class="{ 'btn btn-lg btn-block': true, 'btn-success': editionIsOpen, 'btn-warning': !editionIsOpen, 'disabled': !editionIsOpen }">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Emet vots
                    </a>
                </div>
                <div class="col-sm">
                    <a v-if="!anonymousVoting" href="" :class="{ 'btn btn-danger btn-lg btn-block': true, 'disabled': !editionIsOpen }"><i class="fa fa-ban" aria-hidden="true"></i> Anul·la vot</a>
                </div>
                <div class="col-sm">
                    <a v-if="enableIDLookUp" href="" class="btn btn-secondary btn-lg btn-block"><i class="fa fa-search" aria-hidden="true"></i> Troba per DNI</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'edition',

        props: {
            edition: Object
        },

        data() {
            return {
                anonymousVoting: false,
                enableIDLookUp: false
            }
        },

        computed: {
            editionIsOpen: function() {
                return false;
            }
        },

        mounted() {
            this.anonymousVoting = window.app.config.anonymous_voting;
            this.enableIDLookUp = window.app.config.enable_ID_lookup;
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../sass/_variables';

    .vote-status {
        font-size: 2rem;
    }

    .vote-status--open {
        color: $green;
    }

    .vote-status--closed {
        color: $gray-light;
    }
</style>

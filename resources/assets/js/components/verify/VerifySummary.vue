<template>
    <div class="ballot-summary">
        <button @click="goBack()" class="btn btn-secondary btn-sm">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            {{ $t('verify_summary.edit') }}
        </button>

        <div v-for="question in selected">
            <h3>{{ question.question }}</h3>
            <ul class="options">
                <li v-for="option in question.options">
                    <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ option.option }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'verify-summary',

        props: {
            selected: Array
        },

        methods: {
            goBack() {
                Bus.$emit('goToStep', '/');
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../../../sass/_variables';

    .ballot-summary {
        position: relative;
        max-width: 500px;
        border: 4px $gray-lighter solid;
        margin: 0 auto;
        padding: 2rem;

        h3 {
            font-size: 1.2rem;
        }

        .options {
            list-style: none;
            padding-left: 0;
            
            li {

            }
        }

        .btn {
            position: absolute;
            top: 0;
            right: 0;
            background: $gray-lighter;
            border-color: $gray-lighter;
        }
    }
</style>

<template>
    <div>
        <form @submit.prevent="castBallot">
            <button :class="'btn btn-primary btn-lg' + disabled" type="submit">
                <spinner icon="bullhorn" :loading="isLoading" />
                Confirmar
            </button>
        </form>
    </div>
</template>

<script>

    import Spinner from '../helpers/Spinner';

    export default {
        name: 'verify-in-person',

        components: {
            Spinner
        },

        data() {
            return {
                isLoading: false,
            }
        },

        computed: {
            disabled: function() {
                return this.isLoading ? ' disabled' : ''
            }
        },

        created() {
            Bus.$on('VerifyPhoneLoading', (isLoading) => this.isLoading = isLoading);
        },

        methods: {
            castBallot() {
                Bus.$emit('castBallot');
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

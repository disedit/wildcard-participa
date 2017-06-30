<template>
    <div class="ballot-identification">
        <h3><i class="fa fa-user" aria-hidden="true"></i> Identificació</h3>
        <p>Pots votar si tens més de <strong>16 anys</strong> i estàs empadronat a <strong>La Font de la Figuera</strong></p>
        <text-input name="identification" label="DNI/NIE o Pasaporte" tooltip="Help" icon="user" :required="true" :value="identifier" @update="updateID" />

        <hr />

        <button :class="'btn btn-vote btn-primary btn-lg btn-block' + disabled" type="submit">
            <i v-if="disabled" class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
            <i v-else class="fa fa-bullhorn" aria-hidden="true"></i>
            Vota
        </button>
    </div>
</template>

<script>
    import TextInput from '../helpers/TextInput';

    export default {
        name: 'ballot-identification',

        components: {
            TextInput
        },

        props: {
            loading: Boolean,
            identifier: String
        },

        computed: {
            disabled: function() {
                return this.loading ? ' disabled' : ''
            }
        },

        methods: {
            updateID(value) {
                Bus.$emit('fieldUpdated', 'ID', value);
            }
        }

    }
</script>

<style scoped lang="scss">
    @import '../../../sass/_variables';

    .ballot-identification {
        background: $gray-lighter;
        margin-top: 2rem;
        padding: 1rem;
    }

    h3 {
        font-weight: bold;
    }

</style>

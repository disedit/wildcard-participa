<template>
    <div>
        <h2>
            ID
            <b-tooltip content="Online!">
                Help
            </b-tooltip>
        </h2>
        <input type="text" class="form-control input-lg" name="identification" :value="identifier" @input="updateID($event.target.value)" />

        <button :class="'btn btn-primary btn-lg' + disabled" type="submit">
            <i v-if="disabled" class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
            <i v-else class="fa fa-bullhorn" aria-hidden="true"></i>
            Vota
        </button>
    </div>
</template>

<script>
    export default {
        name: 'ballot-identification',

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

</style>

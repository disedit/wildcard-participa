<template>
    <modal v-if="anyErrors">
        <h4 slot="header">Error</h4>

        <div>
            {{ errors }}
        </div>

        <div slot="buttons">
            Here be buttons
        </div>
    </modal>
</template>

<script>
    import Modal from './Modal';

    export default {
        name: 'error-modal',

        components: {
            Modal
        },

        props: {
            errors: Object
        },

        computed: {
            anyErrors: function() {
                return Object.keys(this.errors).length > 0;
            }
        },

        methods: {
            close() {
                Bus.$emit('FieldUpdated', 'errors', {});
            }
        }
    }
</script>

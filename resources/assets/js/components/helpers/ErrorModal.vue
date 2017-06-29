<template>
    <b-modal id="errorsModal" @hidden="close" :ok-only="true" ok-title="Torna" size="lg" :hide-header="true" :visible="anyErrors">

        <h4 slot="modal-title">Errors</h4>

        <div>
            {{ errors }}
        </div>

    </b-modal>
</template>

<script>
    export default {
        name: 'error-modal',

        props: {
            errors: Object
        },

        computed: {
            anyErrors: function() { return Object.keys(this.errors).length > 0; }
        },

        methods: {
            close() {
                Bus.$emit('FieldUpdated', 'errors', {});
            }
        }
    }
</script>

<template>
    <b-modal id="errorsModal" ref="errorsModal" @hidden="close" size="lg" :hide-header="true" :visible="anyErrors">

        <div class="error">
            <div class="error__header">
                <i class="fa fa-hand-o-down" aria-hidden="true"></i>
                <h2>Error</h2>
            </div>

            <div v-for="errorField in errors">
                <div v-for="error in errorField" class="error__message">
                    {{ error }}
                </div>
            </div>

            <div class="error__message error__message--contest">
                Si penses que es tracta d'un error o necessites ajuda, posa't en contacte amb tavernes@disedit.com
            </div>
        </div>

        <div slot="modal-footer" class="error__footer">
            <button class="btn btn-primary" @click="$refs.errorsModal.hide();">Torna a la votació</button>
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
                Bus.$emit('fieldUpdated', 'errors', {});
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../sass/_variables';

    .error {

        &__header {
            text-align: center;
            margin-top: 20px;

            i {
                font-size: 68px;
                color: $gray;
            }

            h2 {
                font-size: 46px;
                color: $gray;
            }
        }

        &__message {
            text-align: center;
            width: 100%;
            max-width: 500px;
            margin: 15px auto;
            border: 2px $brand-danger solid;
            color: $brand-danger;
            border-radius: 5px;
            padding: 12px;
            font-size: 18px;
        }

        &__message--contest {
            background: #FFF;
            color: $gray-light;
            font-size: 14px;
            border: 2px $gray-light solid;
        }

        &__footer {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
</style>

<template>
    <b-modal id="optionModal" ref="optionModal" v-model="active" @hidden="close">
        <div slot="modal-title" class="title">{{ option.option }}</div>

        <div class="error">
            <div v-html="option.description"></div>

            <h4 v-if="option.motivation">{{ $t('option.motivation') }}</h4>
            <div v-html="option.motivation"></div>

            <div v-if="option.cost > 0">
                <hr />
                <strong>{{ $t('option.cost') }}</strong>: {{ option.cost | formatCurrency }}
            </div>
        </div>

        <div slot="modal-footer">
            <button @click="close" class="btn btn-secondary">{{ $t('option_modal.dismiss_button') }}</button>
            <button v-if="showSelect && selected" @click="toggleOption" class="btn btn-danger">
                <i class="fa fa-window-close" aria-hidden="true"></i> {{ $t('option_modal.diselect_button') }}
            </button>
            <button v-if="showSelect && !selected" @click="toggleOption" class="btn btn-primary">
                <i class="fa fa-check-square-o" aria-hidden="true"></i> {{ $t('option_modal.select_button') }}
            </button>
        </div>
    </b-modal>
</template>

<script>
    import format from 'format-number';

    export default {
        name: 'option-modal',

        data() {
            return {
                active: false,
                option: {},
                type: 'radio',
                showSelect: false,
                selected: false
            }
        },

        filters: {
            formatCurrency: function(value) {
                return format({ suffix: '€', integerSeparator: '.', round: 0 })(value);
            }
        },

        created() {
            Bus.$on('openOptionModal', (option, type, showSelect, selected) => this.open(option, type, showSelect, selected));
        },

        methods: {
            open(option, type, showSelect, selected) {
                this.option = option;
                this.type = type;
                this.showSelect = showSelect;
                this.selected = selected;
                this.active = true;
            },
            close() {
                this.active = false;
            },
            toggleOption() {
                Bus.$emit('optionSelected', this.option, this.type);
                this.close();
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../../sass/_variables';

    .title {
        color: $brand-primary;
    }
</style>

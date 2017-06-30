<template>
    <div :class="{ 'custom-checkbox': (type == 'checkbox'), 'custom-radio': (type == 'radio') ,'custom-control': true }">
        <input
            :name="'ballot[' + option.question_id + ']'"
            :value="option.id"
            :type="type"
            :disabled="disabled"
            :checked="selected"
            @change="selectOption(option, type)"
            class="custom-control-input" />

        <span class="custom-control-indicator"></span>

        <span class="custom-control-description">
            <span class="option-name">{{ option.option }}</span>
            <span v-if="display_cost && option.cost > 0" class="option-cost">{{ option.cost }}</span>
            <i v-if="selected" class="fa fa-check" aria-hidden="true"></i>
            <a href="#" v-if="option.description" class="option-info" @click.prevent="displayInfo">{{ $t('booth_option.more_info') }}</a>
        </span>
    </div>
</template>

<script>
    export default {
        name: 'ballot-option',

        props: {
            option: Object,
            type: String,
            selected: Boolean,
            disabled: Boolean,
            display_cost: Boolean
        },

        methods: {
            selectOption(option, type) {
                Bus.$emit('optionSelected', option, type);
            },

            displayInfo() {
                console.log(this.option);
            }
        }
    }
</script>

<style scoped lang="scss">
    @import '../../../sass/_variables';

    .disabled-option {
        color: $gray-lighter;
    }
</style>

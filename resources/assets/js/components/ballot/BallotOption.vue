<template>
    <label :class="{ 'disabled-option': disabled, 'custom-checkbox': (type == 'checkbox'), 'custom-radio': (type == 'radio') ,'custom-control': true }">
        <input
            :name="'ballot[' + option.question_id + ']'"
            :value="option.id"
            :type="type"
            :disabled="disabled"
            :checked="selected"
            @change="selectOption(option, type)"
            class="custom-control-input" />
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description">{{ option.option }} {{ selected }}</span>
    </label>
</template>

<script>
    export default {
        name: 'ballot-option',

        props: {
            option: Object,
            type: String,
            selected: Boolean,
            disabled: Boolean
        },

        methods: {
            selectOption(option, type) {
                Bus.$emit('optionSelected', option, type);
            }
        }
    }
</script>

<style scoped lang="scss">
    .disabled-option {
        color: grey;
    }
</style>

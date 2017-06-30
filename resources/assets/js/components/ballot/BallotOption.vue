<template>
    <label :class="{ 'disabled-option': disabled, 'selected-option': selected, 'custom-checkbox': (type == 'checkbox'), 'custom-radio': (type == 'radio') ,'custom-control': true }">
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
    label {
        display: flex;
        margin: -0.75rem -1.25rem;
        padding: 0.75rem 1.25rem;
    }

    .disabled-option {
        color: grey;
    }
</style>

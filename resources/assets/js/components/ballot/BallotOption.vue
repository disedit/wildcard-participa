<template>
    <label :class="{ 'disabled-option': disabled } ">
        <input
            :name="'ballot[' + option.question_id + ']'"
            :value="option.id"
            :type="type"
            :disabled="disabled"
            @change="selectOption(option, type)" />
        {{ option.option }}
        {{ selected }}
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

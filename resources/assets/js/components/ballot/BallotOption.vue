<template>
    <label>
        <input
            :name="'ballot[' + option.question_id + ']'"
            :value="option.id"
            :type="type"
            @change="selectOption(option)" />
        {{ option.option }}
    </label>
</template>

<script>
    export default {
        name: 'ballot-option',

        props: {
            option: Object,
            type: String
        },

        methods: {
            selectOption(option) {
                Bus.$emit('optionSelected', option);
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

<template>
    <div>
        <button @click="goBack()" class="btn btn-default">Tornar</button>
        <div v-for="question in selected">
            <h2>{{ question.question }}</h2>
            <li v-for="option in question.options">
                {{ option.option }}
            </li>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'verify-summary',

        props: {
            selected: Array
        },

        methods: {
            goBack() {
                Bus.$emit('goToStep', 1);
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

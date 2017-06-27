<template>
    <div>
        <button @click="goBack()" class="btn btn-default">Tornar</button>
        <pre>{{ selected }}</pre>
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

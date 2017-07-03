<template>
    <div>
        <div class="ballot-box">
            {{ edition.name }}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'sidebar',

        props: {
            edition: Object,
        }
    }
</script>

<style scoped lang="scss">

</style>

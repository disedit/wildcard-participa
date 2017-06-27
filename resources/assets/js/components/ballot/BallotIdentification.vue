<template>
    <div>
        <h2>ID</h2>
        <input type="text" name="identification" @input="updateID($event.target.value)" />

        <button type="submit">Envia</button>
    </div>
</template>

<script>
    export default {
        name: 'ballot-identification',

        methods: {
            updateID(value) {
                Bus.$emit('IDUpdated', value);
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

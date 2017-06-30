<template>
    <div class="row ballot-confirmation">
        <div class="col-md-12">
            <h1>Thanks</h1>
            <pre>{{ receipt }}</pre>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'booth-receipt',

        props: {
            receipt: Object
        }
    }
</script>

<style scoped lang="scss">

</style>

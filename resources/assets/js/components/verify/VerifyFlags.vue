<template>
    <div class="flag">
        <div v-if="flag.name == 'SMS_already_sent'">
            SMS_already_sent
        </div>

        <div v-if="flag.name == 'SMS_exceeded'">
            SMS_exceeded
        </div>
    </div>
</template>

<script>
    export default {
        name: 'verify-flags',

        props: {
            flag: [Boolean, Object]
        }
    }
</script>

<style scoped lang="scss">

</style>

<template>
    <div class="row">
        <div class="col-md-6">
            <verify-summary :selected="selected" />
        </div>
        <div class="col-md-6">
            <verify-phone :phone="phone" :sms-code="smsCode" :sms-requested="smsRequested" />
        </div>
    </div>
</template>

<script>
    import VerifyPhone from './verify/VerifyPhone';
    import VerifySummary from './verify/VerifySummary';

    export default {
        name: 'booth-verify',

        components: {
            VerifyPhone,
            VerifySummary
        },

        props: {
            phone: String,
            selected: Array,
            smsCode: String,
            smsRequested: Boolean
        }
    }
</script>

<style scoped lang="scss">

</style>

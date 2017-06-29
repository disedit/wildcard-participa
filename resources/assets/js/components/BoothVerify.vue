<template>
    <div class="row ballot-verify">
        <div class="col-md-6">
            <verify-summary :selected="selected" />
        </div>
        <div class="col-md-6">
            <verify-in-person v-if="booth_mode" />
            <verify-phone v-else :phone="phone" :sms-code="smsCode" :sms-requested="smsRequested" />
        </div>
    </div>
</template>

<script>
    import VerifyPhone from './verify/VerifyPhone';
    import VerifyInPerson from './verify/VerifyInPerson';
    import VerifySummary from './verify/VerifySummary';

    export default {
        name: 'booth-verify',

        components: {
            VerifyPhone,
            VerifyInPerson,
            VerifySummary
        },

        props: {
            phone: String,
            selected: Array,
            smsCode: String,
            smsRequested: Boolean
        },

        data() {
            return {
                booth_mode: false
            }
        },

        created() {
            this.booth_mode = window.BoothMode;
        }
    }
</script>

<style scoped lang="scss">

</style>

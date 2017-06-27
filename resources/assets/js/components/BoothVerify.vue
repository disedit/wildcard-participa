<template>
    <div class="row">
        <div class="col-md-6">
            <pre>{{ selected }}</pre>
        </div>
        <div class="col-md-6">
            <verify-phone :phone="phone" :sms-code="smsCode" :sms-requested="smsRequested" />
            <hr />
            <button @click="goBack()" class="btn btn-primary">Tornar</button>
        </div>
    </div>
</template>

<script>
    import VerifyPhone from './verify/VerifyPhone';

    export default {
        name: 'booth-verify',

        components: {
            VerifyPhone
        },

        props: {
            phone: String,
            selected: Array,
            smsCode: String,
            smsRequested: Boolean
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

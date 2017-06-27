<template>
    <div>
        <form @submit.prevent="requestSMS">
            <h2>Phone</h2>
            <input
                type="text"
                class="form-control input-lg"
                name="phone"
                :value="phone"
                @input="updatePhone($event.target.value)"
                :disabled="smsRequested" />

            <button v-show="!smsRequested" :class="'btn btn-primary btn-lg' + disabled" type="submit">
                <i v-if="disabled" class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
                <i v-else class="fa fa-bullhorn" aria-hidden="true"></i>
                Send SMS
            </button>
        </form>

        <form v-if="smsRequested" @submit.prevent="castBallot">
            <input
                type="text"
                class="form-control input-lg"
                name="sms_code"
                :value="smsCode"
                @input="updateSMSCode($event.target.value)" />

            <button :class="'btn btn-primary btn-lg' + disabled" type="submit">
                <i v-if="disabled" class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
                <i v-else class="fa fa-bullhorn" aria-hidden="true"></i>
                Verify SMS
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        name: 'verify-phone',

        props: {
            phone: String,
            smsCode: String,
            smsRequested: Boolean,
        },

        data() {
            return {
                isLoading: false
            }
        },

        computed: {
            disabled: function() {
                return this.isLoading ? ' disabled' : ''
            }
        },

        created() {
            Bus.$on('VerifyPhoneLoading', (isLoading) => this.isLoading = isLoading);
        },

        methods: {
            updatePhone(value) {
                Bus.$emit('FieldUpdated', 'phone', value);
            },

            updateSMSCode(value) {
                Bus.$emit('FieldUpdated', 'smsCode', value);
            },

            requestSMS() {
                Bus.$emit('requestSMS');
            },

            castBallot() {
                Bus.$emit('castBallot');
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

<template>
    <div class="verify-phone">
        <transition name="fade">
            <form v-if="!smsRequested" @submit.prevent="requestSMS">
                <button v-show="canBeModified" @click="modifyPhone" class="btn btn-secondary btn-sm" type="button">Modifica</button>
                <h3>
                    <i class="fa fa-mobile" aria-hidden="true"></i> {{ $t('verify_phone.heading') }}
                </h3>

                <phone-input
                    name="phone"
                    :label="$t('verify_phone.label')"
                    :tooltip="$t('verify_phone.tooltip')"
                    :required="true"
                    :value="phone"
                    :country-code="countryCode"
                    :disabled="smsRequested"
                    @update="updatePhone"
                    @updateCountryCode="updateCountryCode" />

                <button v-show="!smsRequested" :class="'btn btn-primary btn-block btn-lg' + disabled" type="submit">
                    <spinner icon="bullhorn" :loading="isLoading" />
                    Send SMS
                </button>
            </form>
        </transition>

        <transition name="fade">
            <form v-if="smsRequested" @submit.prevent="castBallot">
                <input
                    type="text"
                    class="form-control input-lg"
                    name="sms_code"
                    :value="smsCode"
                    @input="updateSMSCode($event.target.value)"
                    v-focus="smsCodeFocused"
                    @focus="smsCodeFocused = true"
                    @blur="smsCodeFocused = false" />

                <verify-flags :flag="flag" />

                <button :class="'btn btn-primary btn-lg' + disabled" type="submit">
                    <spinner icon="bullhorn" :loading="isLoading" />
                    Verify SMS
                </button>
            </form>
        </transition>
    </div>
</template>

<script>
    import Spinner from '../helpers/Spinner';
    import VerifyFlags from './VerifyFlags';
    import CountryCodes from '../helpers/CountryCodes';
    import PhoneInput from '../helpers/PhoneInput';

    export default {
        name: 'verify-phone',

        components: {
            Spinner,
            VerifyFlags,
            CountryCodes,
            PhoneInput,
        },

        props: {
            phone: String,
            countryCode: Number,
            smsCode: String,
            smsRequested: Boolean,
        },

        data() {
            return {
                isLoading: false,
                smsCodeFocused: false,
                flag: false
            }
        },

        computed: {
            disabled: function() {
                return this.isLoading ? ' disabled' : ''
            },
            canBeModified: function() {
                let SMS_exceeded = false;
                if(typeof this.flag == 'object') {
                    if(this.flag.name == 'SMS_exceeded') SMS_exceeded = true;
                }
                return this.smsRequested == true && !SMS_exceeded;
            }
        },

        created() {
            Bus.$on('VerifyPhoneLoading', (isLoading) => this.isLoading = isLoading);
            Bus.$on('setFlag', (flag) => this.flag = flag);
        },

        methods: {
            updatePhone(value) {
                Bus.$emit('fieldUpdated', 'phone', value);
            },

            updateSMSCode(value) {
                Bus.$emit('fieldUpdated', 'smsCode', value);
            },

            updateCountryCode(value) {
                Bus.$emit('fieldUpdated', 'countryCode', Number(value));
            },

            modifyPhone(){
                Bus.$emit('fieldUpdated', 'smsRequested', false);
                Bus.$emit('fieldUpdated', 'smsCode', '');
                this.flag = false;
            },

            requestSMS() {
                Bus.$emit('requestSMS');
                this.smsCodeFocused = true;
            },

            castBallot() {
                Bus.$emit('castBallot');
            }
        }

    }
</script>

<style scoped lang="scss">
    .verify-phone {
        position: relative;
        height: 200px;

        form {
            position: absolute;
            width: 100%;
        }
    }
</style>

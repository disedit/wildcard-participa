<template>
    <div class="verify-phone">
        <form @submit.prevent="requestSMS">
            <h3>
                <i class="fa fa-mobile" aria-hidden="true"></i> {{ $t('verify_phone.heading') }}
            </h3>

            <p class="subheading">{{ $t('verify_phone.phone_subheading') }}</p>

            <phone-input
                name="phone"
                ref="phone"
                :label="$t('verify_phone.phone_label')"
                :required="true"
                :value="phone"
                :country-code="countryCode"
                :disabled="smsRequested"
                @update="updatePhone"
                @updateCountryCode="updateCountryCode">
                    <button v-show="canBeModified" @click="modifyPhone" class="btn btn-edit btn-secondary btn-sm" type="button">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </button>
            </phone-input>

            <transition name="slide" mode="out-in">
                <button v-show="!smsRequested" :class="'btn btn-primary btn-block btn-lg' + disabled" type="submit">
                    <spinner icon="bullhorn" :loading="isLoading" />
                    {{ $t('verify_phone.request_sms_button') }}
                </button>
            </transition>
        </form>


        <transition name="slide" mode="out-in">
            <form v-if="smsRequested" @submit.prevent="castBallot">
                <hr />

                <p class="subheading">{{ $t('verify_phone.code_subheading') }}</p>

                <text-input
                    name="sms_code"
                    ref="sms_code"
                    :label="$t('verify_phone.code_label')"
                    :tooltip="$t('verify_phone.code_tooltip')"
                    :required="true"
                    :value="smsCode"
                    :autofocus="true"
                    @update="updateSMSCode" />

                <verify-flags :flag="flag" />

                <button :class="'btn btn-success btn-block btn-lg' + disabled" type="submit">
                    <spinner icon="check" :loading="isLoading" />
                    {{ $t('verify_phone.cast_ballot_button') }}
                </button>
            </form>
        </transition>
    </div>
</template>

<script>
    import Spinner from '../helpers/Spinner';
    import VerifyFlags from './VerifyFlags';
    import PhoneInput from '../helpers/PhoneInput';
    import TextInput from '../helpers/TextInput';

    export default {
        name: 'verify-phone',

        components: {
            Spinner,
            VerifyFlags,
            PhoneInput,
            TextInput
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

        mounted() {
            this.$refs.phone.$refs.phone.focus();
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
                this.$refs.phone.$refs.phone.focus();
            },

            modifyPhone(){
                Bus.$emit('fieldUpdated', 'smsRequested', false);
                Bus.$emit('fieldUpdated', 'smsCode', '');
                this.flag = false;
                this.$refs.phone.$refs.phone.focus();
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
    .btn-edit {
        position: absolute;
        z-index: 150;
        right: 1rem;
        top: 1.3rem;
    }
</style>

<template>
    <div>
            <form @submit.prevent="requestSMS">
                <h2>
                    Phone
                    <button v-show="canBeModified" @click="modifyPhone" class="btn btn-default btn-small" type="button">Modifica</button>
                </h2>

                <country-codes :value="countryCode" />

                <input
                    type="text"
                    class="form-control input-lg"
                    name="phone"
                    :value="phone"
                    @input="updatePhone($event.target.value)"
                    :disabled="smsRequested"
                    v-focus="phoneFocused"
                    @focus="phoneFocused = true"
                    @blur="phoneFocused = false" />

                <transition name="fade">
                    <button v-show="!smsRequested" :class="'btn btn-primary btn-lg' + disabled" type="submit">
                        <spinner icon="bullhorn" :loading="isLoading" />
                        Send SMS
                    </button>
                </transition>
            </form>
        </transition>

        <verify-flags :flag="flag" />

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

                <button :class="'btn btn-primary btn-lg' + disabled" type="submit">
                    <spinner icon="bullhorn" :loading="isLoading" />
                    Verify SMS
                </button>
            </form>
        </transition>
    </div>
</template>

<script>
    import { focus } from 'vue-focus';
    import Spinner from '../helpers/Spinner';
    import VerifyFlags from './VerifyFlags';
    import CountryCodes from '../helpers/CountryCodes';

    export default {
        name: 'verify-phone',

        directives: {
            focus: focus
        },

        components: {
            Spinner,
            VerifyFlags,
            CountryCodes,
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
                phoneFocused: false,
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
            this.phoneFocused = true;
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

            modifyPhone(){
                Bus.$emit('fieldUpdated', 'smsRequested', false);
                Bus.$emit('fieldUpdated', 'smsCode', '');
                this.flag = false;
                this.smsCodeFocused = false;
                this.phoneFocused = true;
            },

            requestSMS() {
                Bus.$emit('requestSMS');
                this.phoneFocused = false;
                this.smsCodeFocused = true;
            },

            castBallot() {
                Bus.$emit('castBallot');
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

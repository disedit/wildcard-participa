<template>
    <div>
        {{ step }}
        <div v-if="step == 1">
            <booth-ballot
                :identifier="ID"
                :ballot="ballot"
                :selected="selected" />
            <pre>{{ ID }}</pre>
        </div>
        <div v-else-if="step == 2">
            <booth-verify
                :phone="phone"
                :selected="selected"
                :sms-code="smsCode"
                :sms-requested="smsRequested" />
            <pre>{{ phone }}</pre>
        </div>
        <div v-else-if="step == 3">
            <h1>Thanks</h1>
        </div>
    </div>
</template>

<script>
    import BoothBallot from './BoothBallot';
    import BoothVerify from './BoothVerify';

    export default {
        name: 'booth',

        components: {
            BoothBallot,
            BoothVerify
        },

        data() {
          return {
            ballot: {},
            selected: [],
            errors: [],
            ID: '',
            phone: '',
            smsCode: '',
            smsRequested: false,
            step: 1
          }
        },

        created() {
            Participa.getBallot()
                .then(response => {
                    this.ballot = response;
                });

            Bus.$on('optionSelected', (option, type) => this.handleOptionChange(option, type));
            Bus.$on('FieldUpdated', (field, value) => this[field] = value);
            Bus.$on('submitBallotForVerification', () => this.submitBallotForVerification());
            Bus.$on('requestSMS', () => this.requestSMS());
            Bus.$on('castBallot', () => this.castBallot());
            Bus.$on('goToStep', (step) => this.step = step);
        },

        watch: {
            errors: function() {
                if(Object.keys(this.errors).length > 0) {
                    alert('Errors');
                    console.log(this.errors);
                }
            }
        },

        methods: {
            handleOptionChange(option, type) {
                if(type == 'radio') {
                    this.radioOptions(option);
                } else {
                    this.checkboxOptions(option);
                }
            },

            radioOptions(option) {
                let selected = this.selected;

                selected[option.question_id] = new Array(option);

                this.$set(this.selected, option.question_id, selected[option.question_id]);

            },

            checkboxOptions(option) {
                let selected = this.selected;

                if(!selected.hasOwnProperty(option.question_id)){
                    selected[option.question_id] = new Array();
                }

                let selectedIndex = selected[option.question_id].findIndex((o) => o.id == option.id);
                if(selectedIndex >= 0){
                    selected[option.question_id].splice(selectedIndex, 1);
                } else {
                    selected[option.question_id].push(option);
                }

                this.$set(this.selected, option.question_id, selected[option.question_id]);
            },

            submitBallotForVerification() {
                Bus.$emit('BoothBallotLoading', true);

                Participa.precheck({
                    ballot: Participa.prepareBallot(this.selected),
                    SID: this.ID
                }).then(response => {
                    this.step = 2;
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('BoothBallotLoading', false));


            },

            requestSMS() {
                Bus.$emit('VerifyPhoneLoading', true);

                Participa.requestSMS({
                    ballot: Participa.prepareBallot(this.selected),
                    SID: this.ID,
                    phone: this.phone
                }).then(response => {
                    this.smsRequested = true;
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('VerifyPhoneLoading', false));
            },

            castBallot() {
                Bus.$emit('VerifyPhoneLoading', true);

                Participa.castBallot({
                    ballot: Participa.prepareBallot(this.selected),
                    SID: this.ID,
                    phone: this.phone,
                    SMS_code: this.smsCode
                }).then(response => {
                    this.step = 3;
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('VerifyPhoneLoading', false));
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

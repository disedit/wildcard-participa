<template>
    <div>
        <div v-if="step == 1">
            <booth-ballot
                :identifier="ID"
                :ballot="ballot"
                :selected="selected" />
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

        <error-modal :errors="errors" />
    </div>
</template>

<script>
    import BoothBallot from './BoothBallot';
    import BoothVerify from './BoothVerify';
    import ErrorModal from './helpers/ErrorModal';

    export default {
        name: 'booth',

        components: {
            BoothBallot,
            BoothVerify,
            ErrorModal
        },

        data() {
          return {
            ballot: {},
            selected: [],
            errors: {},
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
                    this.initialSelected();
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
                    //alert('Errors');
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
                const questionIndex = selected.findIndex((q) => q.id == option.question_id);

                selected[questionIndex].options = new Array(option);

                this.$set(this.selected, questionIndex, selected[questionIndex]);

            },

            checkboxOptions(option) {
                let selected = this.selected;
                const questionIndex = selected.findIndex((q) => q.id == option.question_id);
                let optionIndex = selected[questionIndex].options.findIndex((o) => o.id == option.id);

                if(optionIndex >= 0){
                    selected[questionIndex].options.splice(optionIndex, 1);
                } else {
                    selected[questionIndex].options.push(option);
                }

                this.$set(this.selected, questionIndex, selected[questionIndex]);
            },

            initialSelected() {
                let ballot = JSON.parse( JSON.stringify( this.ballot.questions ) );

                ballot.forEach(function(question, index) {
                    ballot[index].options = new Array();
                });

                this.selected = ballot;
            },

            submitBallotForVerification() {
                Bus.$emit('BoothBallotLoading', true);

                Participa.precheck({
                    ballot: this.selected,
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
                    ballot: this.selected,
                    SID: this.ID,
                    phone: this.phone
                }).then(response => {
                    this.smsRequested = true;
                    if(response.flag){
                        Bus.$emit('setFlag', response.flag);
                        if(response.flag.name == 'SMS_exceeded'){
                            this.phone = response.flag.info.last_number;
                        }
                    }
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('VerifyPhoneLoading', false));
            },

            castBallot() {
                Bus.$emit('VerifyPhoneLoading', true);

                Participa.castBallot({
                    ballot: this.selected,
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

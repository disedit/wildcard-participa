<template>
    <div>
        <router-link to="/">Step 1</router-link>
        <router-link to="/verify">Step 2</router-link>
        <router-link to="/confirmed">Step 3</router-link>

        <transition name="fade">
            <booth-ballot
                v-if="$route.name == 'ballot'"
                :identifier="ID"
                :ballot="ballot"
                :selected="selected" />
        </transition>
        <transition name="fade">
            <booth-verify
                v-if="$route.name == 'verify'"
                :phone="phone"
                :selected="selected"
                :sms-code="smsCode"
                :sms-requested="smsRequested" />
        </transition>
        <transition>
            <booth-confirmation v-if="$route.name == 'confirmed'" />
        </transition>

        <error-modal :errors="errors" />
    </div>
</template>

<script>
    import VueRouter from 'vue-router';
    import BoothBallot from './BoothBallot';
    import BoothVerify from './BoothVerify';
    import BoothConfirmation from './BoothConfirmation';
    import ErrorModal from './helpers/ErrorModal';

    const router = new VueRouter({
      mode: 'history',
      routes: [
        { name: 'ballot', path: '/', component: BoothBallot },
        { name: 'verify', path: '/verify', component: BoothVerify },
        { name: 'confirmed', path: '/confirmed', component: BoothConfirmation }
      ]
    });

    export default {
        name: 'booth',

        router,

        components: {
            BoothBallot,
            BoothVerify,
            BoothConfirmation,
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
            smsRequested: false
          }
        },

        created() {
            this.loadBallot();
            Bus.$on('optionSelected', (option, type) => this.handleOptionChange(option, type));
            Bus.$on('fieldUpdated', (field, value) => this[field] = value);
            Bus.$on('submitBallotForVerification', () => this.submitBallotForVerification());
            Bus.$on('requestSMS', () => this.requestSMS());
            Bus.$on('castBallot', () => this.castBallot());
            Bus.$on('goToStep', (path) => router.push({ path }));
        },

        methods: {

            /* Fetch ballot from server */
            loadBallot() {
                Participa.getBallot()
                    .then(response => {
                        this.ballot = response;
                        this.initialSelected();
                    });
            },

            /* Load an emtpy ballot onto 'selected' */
            initialSelected() {
                let ballot = JSON.parse( JSON.stringify( this.ballot.questions ) );

                ballot.forEach(function(question, index) {
                    ballot[index].options = new Array();
                });

                this.selected = ballot;
            },

            /* When user selects an option */
            handleOptionChange(option, type) {
                if(type == 'radio') {
                    this.radioOptions(option);
                } else {
                    this.checkboxOptions(option);
                }
            },

            /* Handles option selection for single-choice questions */
            radioOptions(option) {
                let selected = this.selected;
                const questionIndex = selected.findIndex((q) => q.id == option.question_id);

                selected[questionIndex].options = new Array(option);

                this.$set(this.selected, questionIndex, selected[questionIndex]);

            },

            /* Handles option selection for multiple-choice questions */
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

            /* Precheck before step 2. Checks if ID exists or has been used */
            submitBallotForVerification() {
                Bus.$emit('BoothBallotLoading', true);

                Participa.precheck({
                    ballot: this.selected,
                    SID: this.ID
                }).then(response => {
                    router.push({ path: '/verify' });
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('BoothBallotLoading', false));
            },

            /* Request SMS code to verify ballot */
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

            /* Submit SMS code to register ballot */
            castBallot() {
                Bus.$emit('VerifyPhoneLoading', true);

                Participa.castBallot({
                    ballot: this.selected,
                    SID: this.ID,
                    phone: this.phone,
                    SMS_code: this.smsCode
                }).then(response => {
                    router.push({ path: '/confirmed' });
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('VerifyPhoneLoading', false));
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

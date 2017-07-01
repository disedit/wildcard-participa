<template>
    <div class="booth">
        <router-link to="/">Step 1</router-link>
        <router-link to="/booth/verify">Step 2</router-link>
        <router-link to="/booth/receipt">Step 3</router-link>

        <transition :name="transitionName" mode="out-in">
            <router-view
                class="child-view"
                :identifier="ID"
                :ballot="ballot"
                :selected="selected"
                :phone="phone"
                :country-code="countryCode"
                :sms-code="smsCode"
                :sms-requested="smsRequested" />
        </transition>

        <error-modal :errors="errors" />
        <option-modal />
    </div>
</template>

<script>
    import ErrorModal from './helpers/ErrorModal';
    import OptionModal from './helpers/OptionModal';

    export default {
        name: 'booth',

        components: {
            ErrorModal,
            OptionModal
        },

        data() {
          return {
            ballot: {},
            selected: [],
            errors: {},
            receipt: {},
            ID: '',
            phone: '',
            countryCode: 34,
            smsCode: '',
            smsRequested: false,
            transitionName: 'slide-left'
          }
        },

        beforeRouteUpdate (to, from, next) {
            let transitionName = 'slide-left';

            if(from.path == '/booth/verify' && to.path == '/') transitionName = 'slide-right';

            if(from.path == '/booth/receipt' && to.path == '/booth/verify'){
                // Should not be allowed. Redirect to first step
                this.clearBooth();
                this.$router.push({ path: '/' });
            }

            if(from.path == '/booth/receipt' && to.path == '/'){
                // If going from receipt to first step, clear the form
                this.clearBooth();
            }

            this.transitionName = transitionName;
            next();
        },

        created() {
            this.loadBallot();
            Bus.$on('optionSelected', (option, type) => this.handleOptionChange(option, type));
            Bus.$on('fieldUpdated', (field, value) => this[field] = value);
            Bus.$on('submitBallotForVerification', () => this.submitBallotForVerification());
            Bus.$on('requestSMS', () => this.requestSMS());
            Bus.$on('castBallot', () => this.castBallot());
            Bus.$on('goToStep', (path) => this.$router.push({ path }));
        },

        watch: {
            selected: function(){
                this.doneSelecting();
            }
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
                /* Hack: Prevent original ballot value from updating */
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

            /* Scroll to ID field, if all questions have been fully answered */
            doneSelecting() {
                let completed = [];

                this.selected.forEach((question) => completed.push(question.max_options == question.options.length));

                const shouldScroll = completed.every((value) => value === true);

                if(shouldScroll) {
                    Bus.$emit('doneSelecting');
                }
            },

            /* Precheck before step 2. Checks if ID exists or has been used */
            submitBallotForVerification() {
                Bus.$emit('BoothBallotLoading', true);

                Participa.precheck({
                    ballot: this.selected,
                    SID: this.ID
                }).then(response => {
                    this.$router.push({ path: '/booth/verify' });
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
                    phone: '00' + this.countryCode + this.phone
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
                    phone: '00' + this.countryCode + this.phone,
                    SMS_code: this.smsCode
                }).then(response => {
                    this.receipt = response.ballot;
                    this.$router.push({ path: '/booth/receipt' });
                }).catch(errors => {
                    this.errors = errors
                }).then(() => Bus.$emit('VerifyPhoneLoading', false));
            },

            clearBooth() {
                this.initialSelected();

                this.receipt = {};
                this.ID = '';
                this.phone = '';
                this.countryCode = 34;
                this.smsCode = '';
                this.smsRequested = false;
            }
        }
    }
</script>

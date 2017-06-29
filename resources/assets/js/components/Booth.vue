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
            Participa.getBallot()
                .then(response => {
                    this.ballot = response;
                    this.initialSelected();
                });
            console.log(this.$route);
            Bus.$on('optionSelected', (option, type) => this.handleOptionChange(option, type));
            Bus.$on('FieldUpdated', (field, value) => this[field] = value);

            Bus.$on('submitBallotForVerification', () => this.submitBallotForVerification());
            Bus.$on('requestSMS', () => this.requestSMS());
            Bus.$on('castBallot', () => this.castBallot());

            Bus.$on('goToStep', (path) => router.push({ path }));
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
                    router.push({ path: '/verify' });
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

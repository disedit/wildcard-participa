<template>
    <div>
        {{ step }}
        <div v-if="step == 1">
            <booth-ballot :ballot="ballot" :selected="selected" />
            <pre>{{ ID }}</pre>
        </div>
        <div v-else-if="step == 2">

        </div>
    </div>
</template>

<script>
    import BoothBallot from './BoothBallot';

    export default {
        name: 'booth',

        components: {
            BoothBallot
        },

        data() {
          return {
            ballot: {},
            selected: [],
            ID: '',
            phone: '',
            SMS_code: '',
            step: 1
          }
        },

        created() {
            Participa.getBallot()
                .then(response => {
                    this.ballot = response;
                });

            Bus.$on('optionSelected', (option, type) => this.handleOptionChange(option, type));
            Bus.$on('IDUpdated', (ID) => this.ID = ID);
            Bus.$on('submitBallotForVerification', () => this.submitBallotForVerification());
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
                this.step = 2;
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

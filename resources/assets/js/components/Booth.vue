<template>
    <div>
        <booth-ballot :ballot="ballot" :selected="selected" />
        <pre>{{ selected }}</pre>
    </div>
</template>

<script>
    import Participa from '../api';
    import BoothBallot from './BoothBallot';

    export default {
        name: 'booth',

        components: {
            BoothBallot
        },

        data() {
          return {
            api: new Participa(),
            ballot: {},
            selected: [],
            step: 1
          }
        },

        created() {
            this.api.getBallot()
                .then(response => {
                    this.ballot = response;
                });

            Bus.$on('optionSelected', (option, type) => this.handleOptionChange(option, type));
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
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

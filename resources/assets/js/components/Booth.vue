<template>
    <div>
        {{ selected }}
        <div v-for="question in ballot.questions">
            <ballot-question :question="question" />
        </div>
    </div>
</template>

<script>
    import Participa from '../api';
    import BallotQuestion from './ballot/BallotQuestion';

    export default {
        name: 'booth',

        components: {
            BallotQuestion
        },

        data() {
          return {
            api: new Participa(),
            ballot: [],
            selected: []
          }
        },

        created() {
            var self = this;

            this.api.getBallot()
                .then(response => {
                    this.ballot = response;
                });

            Bus.$on('optionSelected', (option) => {
                console.log(option, self.selected);
                let isSelected = this.selected.filter((o) => o.id == option.id);

                if(isSelected){
                    self.selected.push({ hello: 'yes', option: option });
                }

            });
        },

        methods: {

        }
    }
</script>

<style scoped lang="scss">

</style>

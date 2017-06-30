<template>
    <div class="row">
        <div class="col-sm-8">
            <form @submit.prevent="submitBallot">
                <div v-for="question in ballot.questions">
                    <ballot-question :question="question" :selected="selected" />
                </div>

                <ballot-identification :identifier="identifier" :loading="isLoading" />
            </form>
        </div>
        <div class="col-sm-4">
            Sidebarf
        </div>
    </div>
</template>

<script>
    import BallotQuestion from './ballot/BallotQuestion';
    import BallotIdentification from './ballot/BallotIdentification';

    export default {
        name: 'booth-ballot',

        components: {
            BallotQuestion,
            BallotIdentification
        },

        data() {
            return {
                isLoading: false
            }
        },

        props: {
            ballot: Object,
            selected: Array,
            identifier: String,
        },

        created() {
            Bus.$on('BoothBallotLoading', (isLoading) => this.isLoading = isLoading);
        },

        methods: {
            submitBallot() {
                this.isLoading = true;
                Bus.$emit('submitBallotForVerification');
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

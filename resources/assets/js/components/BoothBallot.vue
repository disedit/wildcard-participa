<template>
    <form @submit.prevent="submitBallot">
        <div v-for="question in ballot.questions">
            <ballot-question :question="question" :selected="selected" />
        </div>

        <ballot-identification />
    </form>
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

        props: {
            ballot: Object,
            selected: Array
        },

        methods: {
            submitBallot() {
                Bus.$emit('submitBallotForVerification');
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

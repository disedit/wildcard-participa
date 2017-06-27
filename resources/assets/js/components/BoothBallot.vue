<template>
    <div>
        <div v-for="question in ballot.questions">
            <ballot-question :question="question" :selected="selected" />
        </div>
    </div>
</template>

<script>
    import BallotQuestion from './ballot/BallotQuestion';

    export default {
        name: 'booth-ballot',

        components: {
            BallotQuestion
        },

        props: {
            ballot: Object,
            selected: Array
        }
    }
</script>

<style scoped lang="scss">

</style>

<template>
    <div>
        <h2>{{ question.question }}</h2>
        <li v-for="option in question.options">
            <ballot-option :type="questionType" :option="option" />
        </li>
    </div>
</template>

<script>
    import BallotOption from './BallotOption';

    export default {
        name: 'ballot-question',

        components: {
            BallotOption
        },

        props: {
            question: Object
        },

        computed: {
            questionType: function() {
                return this.question.max_options == 1 ? 'radio' : 'checkbox';
            }
        }
    }
</script>

<style scoped lang="scss">

</style>

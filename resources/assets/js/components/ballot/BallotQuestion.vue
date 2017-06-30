<template>
    <div>
        <h2>{{ question.question }} {{ question.max_options }}</h2>
        <ul class="list-group">
            <li v-for="option in question.options" :class="{ 'list-group-item': true, 'disabled' : isDisabled(option) }">
                <ballot-option :type="questionType" :option="option" :selected="isSelected(option)" :disabled="isDisabled(option)" />
            </li>
        </ul>
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
            question: Object,
            selected: Array
        },

        computed: {
            questionType: function() {
                return this.question.max_options == 1 ? 'radio' : 'checkbox';
            }
        },

        methods: {
            isSelected(option) {
                const questionIndex = this.selected.findIndex((q) => q.id == option.question_id);
                return this.selected[questionIndex].options.filter((o) => o.id == option.id).length == 0 ? false : true;
            },

            isDisabled(option) {
                // Limits are not applied to radio questions
                if(this.question.max_options == 1) return false;

                // Find if we're over the limit of allowed selections
                const questionIndex = this.selected.findIndex((q) => q.id == option.question_id);
                const overLimit = this.selected[questionIndex].options.length >= this.question.max_options ? true : false;

                // If we're not over limit, no options are disabled
                if(!overLimit) return false;

                // We're over the limit. return TRUE if option is not in selected array.
                return !this.isSelected(option);
            }
        }

    }
</script>

<style scoped lang="scss">

</style>

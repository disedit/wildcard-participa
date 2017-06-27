<template>
    <div>
        <h2>{{ question.question }} {{ question.max_options }}</h2>
        <li v-for="option in question.options">
            <ballot-option :type="questionType" :option="option" :selected="isSelected(option)" :disabled="isDisabled(option)" />
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
                // if option.id is present in selected[option.question_id]
                if(this.selected.hasOwnProperty(option.question_id)){
                    return this.selected[option.question_id].filter((o) => o.id == option.id).length != 0 ? true : false;
                }

                return false;
            },

            isDisabled(option) {
                let overLimit = false;

                // Limits are not applied to radio questions
                if(this.question.max_options == 1) return false;

                // If question key is not set, we can't be over limit
                if(!this.selected.hasOwnProperty(option.question_id)) return false;

                // Find if we're over the limit of allowed selections
                overLimit = this.selected[option.question_id].length >= this.question.max_options ? true : false;

                console.log(this.selected[option.question_id].length, '>=', this.question.max_options);
                console.log(overLimit);

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

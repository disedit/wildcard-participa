<template>
  <section :class="'question template-' + question.template"
    :aria-labelledby="'question-' + question.id"
    role="group">
    <div :class="{ 'heading': true, 'has-number': displayNumber }">
      <span v-if="displayNumber" class="number">{{ number }}</span>
      <h2 :id="'question-' + question.id">{{ question.question }}</h2>
      <p class="description">{{ question.description }}</p>
    </div>
    <div
      :class="{
        'option-group': true,
        'list-group': question.template != 'cards'
      }">
      <label
        v-for="option in question.options"
        :key="option.id"
        :class="{
          'option': true,
          'list-group-item list-group-item-action': question.template !== 'cards',
          'disabled' : isDisabled(option),
          'selected' : isSelected(option)
        }">
        <ballot-option
          :type="questionType"
          :option="option"
          :selected="isSelected(option)"
          :disabled="isDisabled(option)"
          :display-cost="displayCost" />
      </label>
    </div>

    <hr  aria-hidden="true" />
  </section>
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
      selected: Array,
      number: Number,
      displayNumber: Boolean
    },

    computed: {
      questionType: function () {
        return this.question.max_options === 1 ? 'radio' : 'checkbox';
      },
      displayCost: function () {
        return this.question.display_cost === 1;
      }
    },

    methods: {
      isSelected (option) {
        const questionIndex = this.selected.findIndex((q) => q.id === option.question_id);
        return this.selected[questionIndex].options.filter((o) => o.id === option.id).length === 0 ? false : true;
      },

      isDisabled (option) {
        // Limits are not applied to radio questions
        if (this.question.max_options === 1) return false;

        // Find if we're over the limit of allowed selections
        const questionIndex = this.selected.findIndex((q) => q.id === option.question_id);
        const overLimit = this.selected[questionIndex].options.length >= this.question.max_options ? true : false;

        // If we're not over limit, no options are disabled
        if (!overLimit) return false;

        // We're over the limit. return TRUE if option is not in selected array.
        return !this.isSelected(option);
      }
    }

  }
</script>

<style scoped lang="scss">
  @import '../../../sass/_variables';

  .question {
    h2 {
      font-size: 1.65rem;
      font-weight: 600;
    }

    .description {
      color: $gray-light;
    }

    .heading {
      position: relative;

      .number {
        color: darken($gray-lighter, 20%);
        font-size: 3rem;
        position: absolute;
        left: -50px;
        top: -15px;
      }
    }
  }
</style>

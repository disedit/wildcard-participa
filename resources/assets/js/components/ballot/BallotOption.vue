<template>
  <div class="option-wrapper">
    <div :class="{
      'custom-checkbox': (type === 'checkbox'),
      'custom-radio': (type === 'radio') ,
      'custom-control': true
    }">
      <input
        :name="'ballot[' + option.question_id + ']'"
        :value="option.id"
        :type="type"
        :disabled="disabled"
        :checked="selected"
        @change="selectOption(option, type)"
        class="custom-control-input" />

      <span class="custom-control-label">
        <span class="option-name" :id="'option-' + option.id">{{ option.option }}</span>
        <span v-if="displayCost && option.cost > 0" class="option-cost">{{ option.cost | formatCurrency }}</span>
      </span>
    </div>
    <a href="#" ref="info" v-if="option.description" class="option-info" @click.prevent="displayInfo">
      {{ $t('booth_option.more_info') }}
    </a>
  </div>
</template>

<script>
  import format from 'format-number';

  export default {
    name: 'ballot-option',

    props: {
      option: Object,
      type: String,
      selected: Boolean,
      disabled: Boolean,
      displayCost: Boolean
    },

    filters: {
      formatCurrency: function (value) {
        if(window.BoothConfig.locale == 'es'
        || window.BoothConfig.locale == 'ca') {
          return format({ suffix: '€', integerSeparator: '.', round: 0 })(value);
        }

        return format({ prefix: '€', integerSeparator: ',', round: 0 })(value);
      }
    },

    mounted () {
      Bus.$on('focusOption', (option) => {
        if (option.id === this.option.id) {
          this.$refs.info.focus();
        }
      });
    },

    methods: {
      selectOption (option, type) {
        Bus.$emit('optionSelected', option, type);
      },

      displayInfo (e) {
        Bus.$emit('openOptionModal', this.option, this.type, true, this.selected);
      }
    }
  }
</script>

<style scoped lang="scss">
  @import '../../../sass/_variables';

  .option-name {
    margin-right: 0.25rem;
  }

  .option-cost {
    color: lighten($gray-light, 10%);
    margin-right: 0.25rem;
  }

  .option-info {
    position: absolute;
    right: 1rem;
    bottom: 0.75rem;
    z-index: 100;
  }

  .costum-control-indicator {
    background: rgba(0, 0, 0, 0.5);
  }

  .disabled {
    .option-name {
      color: lighten($gray-light, 10%);
    }

    .option-cost,
    .option-info {
      color: lighten($gray-light, 30%);
    }
  }
</style>

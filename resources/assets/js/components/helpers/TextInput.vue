<template>
    <div :class="{ 'input': true, 'focused': focused }">
    <label :for="name">
        {{label}}
        <b-tooltip v-if="tooltip" :content="tooltip" class="input-tooltip">
            <i class="fa fa-question-circle" aria-hidden="true"></i>
        </b-tooltip>
    </label>

    <input
        type="text"
        :id="name"
        :name="name"
        :value="value"
        @input="$emit('update', $event.target.value)"
        @focus="focused = true"
        @blur="focused = value ? true : false"
        :required="required"
        class="form-control form-control-lg" />

    </div>
</template>

<script>
    export default {
        name: 'text-input',

        props: {
            name: String,
            label: String,
            icon: String,
            value: String,
            tooltip: String,
            required: Boolean
        },

        data() {
            return {
                focused: false
            }
        },

        mounted() {
            this.focused = this.value ? true : false;
        }
    }
</script>

<style scoped lang="scss">
    @import '../../../sass/_variables';

    .input {
        position: relative;
        height: 80px;

        label {
            z-index: 10;
            position: absolute;
            font-size: 1.2rem;
            top: 1.5rem;
            left: 1.5rem;
            cursor: text;
            transition: 0.5s;
            margin-bottom: 0;
            color: lighten($gray-light, 25%);
        }

        input {
            z-index: 1;
            position: absolute;
            padding-top: 2rem;
            padding-left: 1rem;
            border-width: 0.20rem;
        }
    }

    .input.focused {
        label {
            top: 0.5rem;
            left: 1.2rem;
            font-size: 1rem;
            color: $gray-light;
        }
    }

    .input-tooltip {
        display: inline;
        font-size: 0.9rem;
    }
</style>

<template>
    <div :class="{ 'input': true, 'focused': focused, 'has-warning': warning }">
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
        :ref="name"
        :value="value"
        v-focus="autofocus"
        @input="$emit('update', $event.target.value)"
        @focus="focused = true; $emit('focus');"
        @blur="focused = value ? true : false; $emit('blur');"
        :required="required"
        :class="{ 'form-control form-control-lg': true, 'form-control-warning': warning }" />

    </div>
</template>

<script>
    import { focus } from 'vue-focus';

    export default {
        name: 'text-input',

        directives: { focus },

        props: {
            name: String,
            label: String,
            icon: String,
            value: String,
            tooltip: String,
            required: Boolean,
            autofocus: Boolean,
            warning: Boolean
        },

        data() {
            return {
                focused: false
            }
        },

        mounted() {
            this.focused = this.value || this.autofocus ? true : false;
        }
    }
</script>

<style scoped lang="scss">
    @import '../../../sass/_variables';

    .input {
        position: relative;
        height: 71px;

        label {
            z-index: 10;
            position: absolute;
            font-size: 1.2rem;
            top: 1.4rem;
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
            padding-bottom: 0.5rem;
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

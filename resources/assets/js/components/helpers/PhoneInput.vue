<template>
    <div :class="{ 'input': true, 'focused': focused }">
        <label :for="name">
            <i v-if="icon" :class="'fa fa-' + icon" aria-hidden="true"></i>
            {{label}}
            <b-tooltip v-if="tooltip" :content="tooltip" class="input-tooltip">
                <i class="fa fa-question-circle" aria-hidden="true"></i>
            </b-tooltip>
        </label>

        <input
            ref="phoneField"
            type="text"
            :id="name"
            :name="name"
            :value="value"
            @input="$emit('update', $event.target.value)"
            @focus="focused = true"
            @blur="focused = value ? true : false"
            :required="required"
            class="form-control form-control-lg" />

        <transition name="fade">
            <country-codes v-show="focused" :value="countryCode" @focus="focused = true" @update="updateCountryCode" />
        </transition>
    </div>
</template>

<script>
    import CountryCodes from './CountryCodes';

    export default {
        name: 'phone-input',

        components: {
            CountryCodes
        },

        props: {
            name: String,
            label: String,
            icon: String,
            value: String,
            countryCode: Number,
            tooltip: String,
            required: Boolean,
            disabled: Boolean
        },

        data() {
            return {
                focused: false
            }
        },

        mounted() {
            this.focused = this.value ? true : false;
        },

        methods: {
            updateCountryCode(value) {
                this.$emit('updateCountryCode', value);
                this.$refs.phoneField.focus();
            }
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
            padding-left: 6rem;
            border-width: 0.20rem;
        }

        select {
            position: absolute;
            left: 1.2rem;
            top: 2.3rem;
            width: 4rem;
            z-index: 10;
            background: $gray-lightest;
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

<template>
    <div>
        <label for="dialCode" class="sr-only">{{ $t('verify_phone.country_code') }}</label>
        <select id="dialCode" :value="value" @change="$emit('update', $event.target.value)" @focus="$emit('focus')" :disabled="disabled" class="custom-select">
            <option v-for="code in countryCodes" :value="code.dialCode">+{{ code.dialCode }} - {{ code.name }}</option>
        </select>
    </div>
</template>

<script>
    import country_codes from './country_codes';

    export default {
        name: 'country-codes',

        props: {
            value: Number,
            disabled: Boolean
        },

        data() {
            return {
                countryCodes: country_codes
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import '../../../sass/_variables';

    select {
        background-color: rgba(0, 0, 0, 0.15);
        border-width: 0;
        width: 80px;
        height: 72px;
        @if $enable-rounded {
            border-radius: 0.25rem 0 0 0.25rem;
        } @else {
            border-radius: 0;
        }
    }

    select:disabled {
        background-color: rgba(0, 0, 0, 0.15);
    }
</style>

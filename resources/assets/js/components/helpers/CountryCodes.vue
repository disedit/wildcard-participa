<template>
    <select :value="value" @change="updateCountryCode($event.target.value)"  class="custom-select">
        <option v-for="code in countryCodes" :value="code.dialCode">+{{ code.dialCode }} {{ code.name }}</option>
    </select>
</template>

<script>

    import country_codes from './country_codes';

    export default {
        name: 'country-codes',

        props: {
            value: Number
        },

        data() {
            return {
                countryCodes: country_codes
            }
        },

        methods: {
            updateCountryCode(value) {
                Bus.$emit('fieldUpdated', 'countryCode', value)
            }
        }
    }
</script>

<template>
    <select :value="value" @change="$emit('update', $event.target.value)" @focus="$emit('focus')" :disabled="disabled">
        <option v-for="code in countryCodes" :value="code.dialCode">+{{ code.dialCode }} - {{ code.name }}</option>
    </select>
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

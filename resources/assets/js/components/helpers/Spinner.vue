<template>
    <span>
        <i v-if="loading" class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
        <i v-else :class="'fa fa-' + icon" aria-hidden="true"></i>
    </span>
</template>

<script>
    export default {
        name: 'spinner',

        props: {
            icon: String,
            loading: Boolean
        }
    }
</script>

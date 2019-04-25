<template>
    <button class="btn-primary inline-flex items-center relative" type="button" style="">
        <span :class="{ invisible: processing }"> <slot /> </span>

        <span
            v-if="processing"
            class="absolute"
            style="top: 50%; left: 50%; transform: translate(-50%, -50%)"
        >
            <loader class="text-white" width="32" />
        </span>
    </button>
</template>

<script>
export default {
    props: {
        processing: {
            type: Boolean,
            default: false,
        },
    },
}
</script>

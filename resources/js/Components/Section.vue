<script setup>
const props = defineProps({
    classContent: {
        type: String,
        default: ""
    },
    classFooter: {
        type: String,
        default: ""
    }
});
</script>

<template>
    <div class="section">
        <div
            class="section-content q-pa-md"
            :class="classContent"
        >
            <slot />
        </div>

        <div
            v-if="$slots.footer"
            class="section-footer q-pa-md"
            :class="classFooter"
        >
            <slot name="footer" />
        </div>
    </div>
</template>

<style scoped lang="scss">
.section {
    border-radius: 4px;
    background: var(--bg-section);

    .section-content {
        width: 100%;
    }

    .section-footer {
        border-top: 1px solid $separator-color;
    }
}
</style>


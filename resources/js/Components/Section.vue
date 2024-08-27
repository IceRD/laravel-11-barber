<script setup>
const props = defineProps({
    title: {
        type: String,
        default: ""
    },
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
            v-if="props.title"
            class="q-px-md q-pt-md"
        >
            <h3 class="text-h6 text-weight-bold q-my-none"> {{ props.title }} </h3>
        </div>

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


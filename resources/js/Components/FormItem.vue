<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true
    },
    hasError: {
        type: Boolean,
        required: false
    }
});
</script>

<template>
    <div
        class="form-item full-width row justify-start items-start content-start"
        :class="{ 'has-error': hasError }"
    >
        <div class="form-label column">
            <div class="text-weight-bold">
                {{ label }}
            </div>
            <div
                v-if="$slots.second"
                class="q-mt-md"
            >
                <slot name="second" />
            </div>
        </div>

        <div class="form-content row">
            <div class="col self-center">
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.form-item {
    .form-label {
        display: flex;
        width: 184px;
        min-height: 40px;
        margin-right: 16px;
        padding-top: 8px;
    }

    .form-content {
        max-width: 300px;
        min-width: 300px;
        min-height: 40px;
    }
}

</style>

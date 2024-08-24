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
        <div class="form-label text-weight-bold">
            {{ label }}
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
        align-items: center;
        width: 184px;
        min-height: 40px;
        margin-right: 16px;
    }

    .form-content {
        width: 100%;
        max-width: 300px;
        min-height: 40px;
    }
}

</style>

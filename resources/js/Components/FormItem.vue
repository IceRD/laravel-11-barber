<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true
    },
});
</script>

<template>
    <div class="form-item full-width row items-center content-center">
        <div class="label text-weight-bold">
            {{ label }}
        </div>

        <div class="content">
            <slot />
        </div>
    </div>
</template>

<style scoped lang="scss">
.form-item {
    .label {
        display: flex;
        align-items: center;
        width: 184px;
        min-height: 40px;
        margin-right: 16px;
    }

    .content {
        width: 100%;
        max-width: 300px;
    }
}

</style>

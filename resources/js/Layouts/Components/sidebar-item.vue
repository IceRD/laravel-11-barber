<script setup>
import { ref } from "vue";
import { useQuasar, copyToClipboard } from "quasar"

const props = defineProps({
    title: {
        type: String,
        default: ""
    },
    showCopy: {
        type: Boolean,
        default: false
    }
});

const $q = useQuasar()
const isShowNotify = ref(false)

function copyLink() {
    copyToClipboard(props.title)
        .then(() => {
            isShowNotify.value = true
            $q.notify({
                icon: "",
                type: "positive",
                position: "top",
                message: "Ссылка успешно скопирована",
                timeout: 500,
                group: "copy",
                onDismiss: () => {
                    isShowNotify.value = false
                }
            })
        })
        .catch(() => {
            isShowNotify.value = true
            $q.notify({
                icon: "",
                type: "negative",
                position: "top",
                message: "Ошибка копирования ссылки",
                timeout: 500,
                group: "copy",
                onDismiss: () => {
                    isShowNotify.value = false
                }
            })
        })
}
</script>

<template>
    <q-item clickable>
        <q-item-section>
            {{ title }}
        </q-item-section>
        <q-item-section
            v-if="props.showCopy"
            side
        >
            <q-btn
                size="xs"
                icon="content_copy"
                flat
                dense
                round
                @click="copyLink"
            />
        </q-item-section>
    </q-item>
</template>

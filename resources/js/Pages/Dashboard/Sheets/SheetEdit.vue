<script setup>
import { ref, computed } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import Section from "@components/Section.vue"
import FormItem from "@components/FormItem.vue"
import { router, useForm, usePage } from "@inertiajs/vue3"
import { errorMessage } from "@/utils/validator.js"
import { notify } from "@/utils/helper.js"
import { useQuasar } from "quasar"


const $q = useQuasar()
const $page = usePage()

const isSysAdmin = computed(() => $page.props.auth.isSysAdmin)

const props = defineProps({
    sheet: {
        type: Object,
        default: () => ({})
    },
});

const form = useForm({
    title:             props.sheet.title,
    spreadsheet_id:    props.sheet.spreadsheet_id,
    spreadsheet_name:  props.sheet.spreadsheet_name,
    spreadsheet_range: props.sheet.spreadsheet_range,
    slug:              props.sheet.slug,
    table_header:      props.sheet.table_header,
    disabled:          Boolean(props.sheet.disabled),
});

const submit = () => {
    form.patch(route("dashboard.sheets.update", {
        sheet: props.sheet.id,
    }), {
        onSuccess: () => {
            $q.notify({
                ...notify.success,
                message: "Интеграция успешно сохранена",
            })
        },
    });
};

const pathBack = () => router.get(route("dashboard.sheets.index"))
</script>

<template>
    <dashboard-layout>
        <Header
            title="Редактирование интеграция с Google"
            :path-back="pathBack"
        />

        <div class="sheets-edit-view">
            <q-form
                ref="formRef"
                @submit.prevent="submit"
            >
                <Section>
                    <form-item label="Заголовок">
                        <q-input
                            v-model="form.title"
                            :error="!!form.errors.title || null"
                            :error-message="errorMessage(form.errors.title)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="ID таблицы">
                        <q-input
                            v-model="form.spreadsheet_id"
                            :error="!!form.errors.spreadsheet_id || null"
                            :error-message="errorMessage(form.errors.spreadsheet_id)"
                            type="textarea"
                            class="text-area"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Название таблицы">
                        <q-input
                            v-model="form.spreadsheet_name"
                            :error="!!form.errors.spreadsheet_id || null"
                            :error-message="errorMessage(form.errors.spreadsheet_id)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Диапазон таблицы">
                        <q-input
                            v-model="form.spreadsheet_range"
                            :error="!!form.errors.spreadsheet_range || null"
                            :error-message="errorMessage(form.errors.spreadsheet_range)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Заголовок таблицы">
                        <q-input
                            v-model="form.table_header"
                            :error="!!form.errors.table_header || null"
                            :error-message="errorMessage(form.errors.table_header)"
                            type="textarea"
                            class="text-area"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Уникальная ссылка">
                        <q-input
                            v-model="form.slug"
                            :error="!!form.errors.slug || null"
                            :error-message="errorMessage(form.errors.slug)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>


                    <form-item label="Заблокирован">
                        <q-checkbox v-model="form.disabled" />
                    </form-item>

                    <template #footer>
                        <q-btn
                            color="primary"
                            label="Сохранить"
                            :unelevated="true"
                            type="submit"
                            :disabled="form.processing"
                        />
                    </template>
                </Section>
            </q-form>
        </div>
    </dashboard-layout>
</template>

<style scoped lang="scss">
.sheets-edit-view {
    :deep() {
        textarea{
            max-height: 80px;
        }
    }
}
</style>

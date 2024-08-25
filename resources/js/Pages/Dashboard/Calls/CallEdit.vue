<script setup>
import { computed } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import Section from "@components/Section.vue"
import FormItem from "@components/FormItem.vue"
import { router, useForm, usePage } from "@inertiajs/vue3"
import { errorMessage } from "@utils/validator.js"
import { notify } from "@/utils/helper.js"
import { useQuasar } from "quasar"


const $q = useQuasar()
const $page = usePage()

const isSysAdmin = computed(() => $page.props.auth.isSysAdmin)

const props = defineProps({
    call: {
        type: Object,
        default: () => ({})
    }
});

const form = useForm({
    mango_telnum:       props.call.mango_telnum,
    lost_client_days:   props.call.lost_client_days,
    repeat_client_days: props.call.repeat_client_days,
    new_client_days:    props.call.new_client_days,
    pay_end:            props.call.pay_end,
    tg_chat_id:         props.call.tg_chat_id,
    tg_disabled:        Boolean(props.call.tg_disabled),
});

const submit = () => {
    form.patch(route("dashboard.calls.update", {
        call: props.call.id,
    }), {
        onSuccess: () => {
            $q.notify({
                ...notify.success,
                message: "Настройка пропущенных звонков успешно сохранена",
            })
        },
    });
};

const pathBack = () => router.get(route("dashboard.calls.index"))

</script>

<template>
    <dashboard-layout>
        <Header
            title="Настройка пропущенных звонков"
            :path-back="pathBack"
        />

        <div class="call-edit-view">
            <q-form
                ref="formRef"
                @submit.prevent="submit"
            >
                <Section>
                    <form-item label="Имя партнера">
                        <div> {{ props.call.partner }} </div>
                    </form-item>

                    <form-item label="Партнер заблокирован">
                           <div> {{ props.call.disabled ? "Да" : "Нет" }} </div>
                    </form-item>

                    <form-item label="Mango">
                        <q-input
                            v-model="form.mango_telnum"
                            :error="!!form.errors.mango_telnum || null"
                            :error-message="errorMessage(form.errors.mango_telnum)"
                            mask="# (###) ###-##-##"
                            unmasked-value
                            no-error-icon
                            outlined
                            dense
                            class="q-mb-md"
                        />
                    </form-item>

                    <form-item label="Telegram ID">
                        <q-input
                            v-model="form.tg_chat_id"
                            :error="!!form.errors.tg_chat_id || null"
                            :error-message="errorMessage(form.errors.tg_chat_id)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Новые клиенты">
                        <q-input
                            v-model="form.new_client_days"
                            :error="!!form.errors.new_client_days || null"
                            :error-message="errorMessage(form.errors.new_client_days)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Повторные клиенты">
                        <q-input
                            v-model="form.repeat_client_days"
                            :error="!!form.errors.repeat_client_days || null"
                            :error-message="errorMessage(form.errors.repeat_client_days)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Потерянные клиенты">
                        <q-input
                            v-model="form.lost_client_days"
                            :error="!!form.errors.lost_client_days || null"
                            :error-message="errorMessage(form.errors.lost_client_days)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Оплачено до">
                        <q-input
                            v-if="isSysAdmin"
                            v-model="form.pay_end"
                            :error="!!form.errors.pay_end || null"
                            :error-message="errorMessage(form.errors.pay_end)"
                            no-error-icon
                            outlined
                            dense
                        >
                            <template v-slot:append>
                                <q-icon
                                    name="event"
                                    class="cursor-pointer"
                                >
                                    <q-popup-proxy
                                        cover
                                        transition-show="scale"
                                        transition-hide="scale"
                                    >
                                        <q-date
                                            v-model="form.pay_end"
                                            mask="YYYY-MM-DD"
                                        >
                                            <div class="row items-center justify-end">
                                                <q-btn
                                                    v-close-popup
                                                    label="Закрыть"
                                                    color="primary"
                                                    flat
                                                />
                                            </div>
                                        </q-date>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                        <div v-else> {{ form.pay_end || "Оплата не производилась" }} </div>
                    </form-item>

                    <form-item label="Заблокирован">
                        <q-checkbox
                            v-if="isSysAdmin"
                            v-model="form.tg_disabled"
                        />
                        <div v-else> {{ form.tg_disabled ? "Да" : "Нет" }} </div>
                    </form-item>

                    <template #footer>
                        <q-btn
                            color="primary"
                            label="Сохранить"
                            :unelevated="true"
                            type="submit"
                        />
                    </template>
                </Section>
            </q-form>
        </div>
    </dashboard-layout>
</template>

<style scoped lang="scss">
.call-edit-view {

}
</style>

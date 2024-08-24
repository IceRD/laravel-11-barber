<script setup>
import {computed, ref} from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import Section from "@components/Section.vue"
import FormItem from "@components/FormItem.vue"
import { router, useForm } from "@inertiajs/vue3"
import { errorMessage } from "@utils/validator.js"

const props = defineProps({
    partner: {
        type: Object,
        default: () => ([])
    }
});

const form = useForm({
    name:            props.partner.name,
    organization:    props.partner.organization,
    inn:             props.partner.inn,
    contract_number: props.partner.contract_number,
    email:           props.partner.email,
    telnums:         props.partner.telnums,
    address:         props.partner.address,
    yclients_id:     props.partner.yclients_id,
    start_at:        props.partner.start_at,
    disabled:        Boolean(props.partner.disabled),
});

const telnums = ref(JSON.parse(form.telnums))

const organization = computed({
    get() {
        return form.organization
    },
    set(value) {
        form.organization = value.toUpperCase()
    }
})

const submit = () => {
    form.post(route('dashboard.partners.update', { partner: props.partner.id }));
};

const pathBack = () => router.get(route("dashboard.partners.index"))

</script>

<template>
    <dashboard-layout>
        <Header
            title="Редактирование партнера"
            :path-back="pathBack"
        />

        <div class="partner-edit-view">
            <q-form
                ref="formRef"
                @submit.prevent="submit"
            >
                <Section>
                    <form-item label="Имя партнера">
                        <q-input
                            v-model="form.name"
                            :error="!!form.errors.name || null"
                            :error-message="errorMessage(form.errors.name)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Название филиала">
                        <q-input
                            v-model="organization"
                            :error="!!form.errors.organization || null"
                            :error-message="errorMessage(form.errors.organization)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Номер договора">
                        <q-input
                            v-model="form.contract_number"
                            :error="!!form.errors.contract_number || null"
                            :error-message="errorMessage(form.errors.contract_number)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="ИНН">
                        <q-input
                            v-model="form.inn"
                            :error="!!form.errors.inn || null"
                            :error-message="errorMessage(form.errors.inn)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Email">
                        <q-input
                            v-model="form.email"
                            :error="!!form.errors.email || null"
                            :error-message="errorMessage(form.errors.email)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Адрес организации">
                        <q-input
                            v-model="form.address"
                            :error="!!form.errors.address || null"
                            :error-message="errorMessage(form.errors.address)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Yclients ID">
                        <q-input
                            v-model="form.yclients_id"
                            :error="!!form.errors.yclients_id || null"
                            :error-message="errorMessage(form.errors.yclients_id)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Номера телефонов">
                        <template v-for="(_, index) in telnums">
                            <q-input
                                v-model="telnums[index].number"
                                :error="!!form.errors.telnums || null"
                                :error-message="errorMessage(form.errors.telnums)"
                                mask="# (###) ###-##-##"
                                no-error-icon
                                outlined
                                dense
                                class="q-mb-md"
                                placeholder="Номер"
                            />

                            <q-input
                                v-model="telnums[index].name"
                                :error="!!form.errors.telnums || null"
                                :error-message="errorMessage(form.errors.telnums)"
                                no-error-icon
                                outlined
                                dense
                                placeholder="Имя"
                            />

                            <q-separator
                                v-if="index !== telnums.length - 1"
                                class="q-mb-md q-mt-md"
                            />
                        </template>
                    </form-item>

                    <form-item label="Дата подписания">
                        <q-input
                            v-model="form.start_at"
                            :error="!!form.errors.start_at || null"
                            :error-message="errorMessage(form.errors.start_at)"
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
                                            v-model="form.start_at"
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
                        />
                    </template>
                </Section>
            </q-form>
        </div>
    </dashboard-layout>
</template>

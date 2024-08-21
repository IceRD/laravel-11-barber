<script setup>
import { onMounted, ref } from "vue"
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import Section from "@/Components/Section.vue"
import FormItem from "@/Components/FormItem.vue"
import {router, useForm} from "@inertiajs/vue3"
import { rolesList } from "@/utils/roles.js"

const props = defineProps({
    user: {
        type: Object,
        default: () => ({})
    },
    partners: {
        type: Array,
        default: () => ([])
    }
});

const partnersList = ref([
    {
        id: 0,
        name: "Не указан"
    },
    ...props.partners.map(partner => ({
        id: partner.id,
        name: partner.organization ? `${partner.name} (${partner.organization})` : partner.name
    }))
])

const form = useForm({
    name:        props.user.name,
    password:    "",
    role:        props.user.role,
    partner_id:  props.user.partner_id,
    is_disabled: Boolean(props.user.is_disabled),
});

const isPassword = ref(true)

const submit = () => {
    form.post(route('dashboard.users.update', { user: props.user.id }));
};

const pathBack = () => router.get(route("dashboard.users.index"))

</script>

<template>
    <dashboard-layout>
        <Header
            title="Редактирование пользователя"
            :path-back="pathBack"
        />

        <div class="users-edit-view">
            <q-form
                ref="formRef"
                @submit.prevent="submit"
            >
                <Section>
                    <form-item label="Логин">
                        {{ props.user.login }}
                    </form-item>

                    <form-item label="Пароль">
                        <q-input
                            v-model="form.password"
                            :type="isPassword ? 'password' : 'text'"
                            :error="form.errors.password"
                            no-error-icon
                            outlined
                            dense
                        >
                            <template v-slot:append>
                                <q-icon
                                    :name="isPassword ? 'visibility_off' : 'visibility'"
                                    class="cursor-pointer"
                                    @click="isPassword = !isPassword"
                                />
                            </template>
                        </q-input>
                    </form-item>

                    <form-item label="Имя">
                        <q-input
                            v-model="form.name"
                            :error="!!form.errors.name"
                            no-error-icon
                            outlined
                            dense
                        >
                            <template v-slot:error>
                                Please use maximum 3 characters.
                            </template>
                        </q-input>
                    </form-item>

                    <form-item label="Роль">
                        <q-select
                            v-model="form.role"
                            :options="rolesList"
                            option-value="id"
                            option-label="value"
                            map-options
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Партнер">
                        <q-select
                            v-model="form.partner_id"
                            :options="partnersList"
                            option-value="id"
                            option-label="name"
                            map-options
                            use-input
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Заблокирован">
                        <q-checkbox v-model="form.is_disabled" />
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

<script setup>
import { ref, computed } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import Section from "@components/Section.vue"
import FormItem from "@components/FormItem.vue"
import { router, useForm } from "@inertiajs/vue3"
import { rolesList, roles } from "@/utils/roles.js"
import { errorMessage } from "@/utils/validator.js"
import { notify } from "@/utils/helper.js"
import { useQuasar } from "quasar"


const $q = useQuasar()

const props = defineProps({
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
    login:       "",
    name:        "",
    password:    "",
    role:        roles.user,
    partner_id:  0,
    is_disabled: false,
});

const login = computed({
    get() {
        return form.login
    },
    set(value) {
        form.login = value.trim().toLowerCase()
    }
})

const isPassword = ref(true)

const submit = () => {
    form.post(route("dashboard.users.store"), {
        onSuccess: () => {
            $q.notify({
                ...notify.success,
                message: "Пользователь успешно создан",
            })
        },
    });
};

const pathBack = () => router.get(route("dashboard.users.index"))

</script>

<template>
    <dashboard-layout>
        <Header
            title="Создание пользователя"
            :path-back="pathBack"
        />

        <div class="users-create-view">
            <q-form
                ref="formRef"
                @submit.prevent="submit"
            >
                <Section>
                    <form-item
                        label="Логин"
                        :has-error="!!form.errors.login"
                    >
                        <q-input
                            v-model="login"
                            :error="!!form.errors.login || null"
                            :error-message="errorMessage(form.errors.login)"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item
                        label="Пароль"
                        :has-error="!!form.errors.password"
                    >
                        <q-input
                            v-model="form.password"
                            :type="isPassword ? 'password' : 'text'"
                            :error="!!form.errors.password || null"
                            :error-message="errorMessage(form.errors.password)"
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
                            :error="!!form.errors.name || null"
                            :error-message="errorMessage(form.errors.name)"
                            no-error-icon
                            outlined
                            dense
                        />
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
                            :disabled="form.processing"
                        />
                    </template>
                </Section>
            </q-form>
        </div>
    </dashboard-layout>
</template>

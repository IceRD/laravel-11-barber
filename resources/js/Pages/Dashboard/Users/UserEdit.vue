<script setup>
import { ref, computed } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import Section from "@components/Section.vue"
import FormItem from "@components/FormItem.vue"
import { router, useForm, usePage } from "@inertiajs/vue3"
import { rolesList, rolesNames } from "@/utils/roles.js"
import { errorMessage } from "@/utils/validator.js"
import { notify } from "@/utils/helper.js"
import { useQuasar } from "quasar"


const $q = useQuasar()
const $page = usePage()

const isSysAdmin = computed(() => $page.props.auth.isSysAdmin)

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
    login:       props.user.login,
    name:        props.user.name,
    password:    "",
    role:        props.user.role,
    partner_id:  props.user.partner_id,
    is_disabled: Boolean(props.user.is_disabled),
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
    form.patch(route("dashboard.users.update", {
        user: props.user.id,
    }), {
        onSuccess: () => {
            $q.notify({
                ...notify.success,
                message: "Пользователь успешно сохранен",
            })
        },
    });
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
                    <form-item
                        label="Логин"
                        :has-error="!!form.errors.login"
                    >
                        <q-input
                            v-if="isSysAdmin"
                            v-model="login"
                            :error="!!form.errors.login || null"
                            :error-message="errorMessage(form.errors.login)"
                            no-error-icon
                            outlined
                            dense
                        />

                        <div v-else> {{ login }} </div>
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
                            v-if="isSysAdmin"
                            v-model="form.role"
                            :options="rolesList"
                            option-value="id"
                            option-label="value"
                            map-options
                            outlined
                            dense
                        />
                        <div v-else> {{ rolesNames[form.role] }} </div>
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
                        <q-checkbox
                            v-if="isSysAdmin"
                            v-model="form.is_disabled"
                        />
                        <div v-else> {{ form.is_disabled ? "Да" : "Нет" }} </div>
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

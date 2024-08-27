<script setup>
import { computed } from "vue"
import ProfileLayout from "@layouts/ProfileLayout.vue"
import Header from "@components/Header.vue"
import Section from "@components/Section.vue"
import FormItem from "@components/FormItem.vue"
import { useForm, usePage } from "@inertiajs/vue3"
import { errorMessage } from "@utils/validator.js"
import { notify } from "@/utils/helper.js"
import { useQuasar } from "quasar"
import { rolesNames } from "@/utils/roles.js";


const $q = useQuasar()
const $page = usePage()

const login = computed(() => $page.props.auth.user.login)
const role = computed(() => $page.props.auth.user.role)

console.log($page.props)

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: ""
});

const submit = () => {
    form.patch(route("profile.update"), {
        onSuccess: () => {
            $q.notify({
                ...notify.success,
                message: "Настройка пользователя обновлены",
            })
        },
    });
};

</script>

<template>
    <profile-layout>
        <Header title="Профиль пользователя" />

        <div class="profile-view">
            <q-form
                ref="formRef"
                @submit.prevent="submit"
            >
                <Section>
                    <form-item label="Логин">
                        <div> {{ login }} </div>
                    </form-item>

                    <form-item label="Роль">
                        <div> {{ rolesNames[role] }} </div>
                    </form-item>
                </Section>

                <Section title="Смена пароля">
                    <form-item label="Текущий пароль">
                        <q-input
                            v-model="form.current_password"
                            :error="!!form.errors.current_password || null"
                            :error-message="errorMessage(form.errors.current_password)"
                            type="password"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Новый пароль">
                        <q-input
                            v-model="form.password"
                            :error="!!form.errors.password || null"
                            :error-message="errorMessage(form.errors.password)"
                            type="password"
                            no-error-icon
                            outlined
                            dense
                        />
                    </form-item>

                    <form-item label="Подтвердить пароль">
                        <q-input
                            v-model="form.password_confirmation"
                            :error="!!form.errors.password_confirmation || null"
                            :error-message="errorMessage(form.errors.password_confirmation)"
                            type="password"
                            no-error-icon
                            outlined
                            dense
                        />
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
    </profile-layout>
</template>

<style scoped lang="scss">
.profile-view {

}
</style>

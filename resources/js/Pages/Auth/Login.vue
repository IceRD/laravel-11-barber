<script setup>
import { ref, computed } from "vue"
import { Head, useForm } from "@inertiajs/vue3"
import { assetsImageUrl } from "@utils/helper.js"
import { require } from "@utils/validator.js"
import GuestLayout from "@layouts/GuestLayout.vue"

const form = useForm({
    login:    "",
    password: "",
    remember: true,
});

const isPassword = ref(true)
const hasError = computed(() => {
    return !!Object.keys(form.errors).length
})

const submit = () => {
    form.post(route('login'), {});
};
</script>

<template>
    <guest-layout>
        <div class="login-view window-height row justify-center items-center content-center">
            <Head title="Авторизация" />

            <div class="login-view-form">
                <q-img
                    :src="assetsImageUrl('logo.png')"
                    class="q-mb-lg"
                />

                <q-form
                    ref="formRef"
                    @submit.prevent="submit"
                    class="q-gutter-y-md"
                >
                    <q-input
                        v-model="form.login"
                        label="Логин"
                        outlined
                        :rules="[ require ]"
                        no-error-icon
                    />

                    <q-input
                        v-model="form.password"
                        :type="isPassword ? 'password' : 'text'"
                        label="Пароль"
                        outlined
                        :rules="[ require ]"
                        no-error-icon
                    >
                        <template v-slot:append>
                            <q-icon
                                :name="isPassword ? 'visibility_off' : 'visibility'"
                                class="cursor-pointer"
                                @click="isPassword = !isPassword"
                            />
                        </template>
                    </q-input>

                    <div class="q-mt-none">
                        <q-checkbox
                            v-model="form.remember"
                            label="Запомнить"
                        />
                    </div>

                    <div
                        v-if="hasError"
                        class="text-negative"
                    >
                        Неверный логин или пароль.
                    </div>

                    <q-btn
                        label="Войти"
                        type="submit"
                        color="primary"
                        class="full-width"
                        :disabled="form.processing"
                    />
                </q-form>
            </div>
        </div>
    </guest-layout>
</template>

<style scoped lang="scss">
.login-view {
    &-form {
        width: 100%;
        max-width: 300px;
    }
}
</style>

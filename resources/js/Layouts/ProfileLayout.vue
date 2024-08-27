<script setup>
import { ref, onMounted } from "vue"
import { router, usePage } from "@inertiajs/vue3"
import { assetsImageUrl } from "@/utils/helper.js"
import { checkAdminAccount } from "@/utils/roles.js"
import SidebarItem from "@/Layouts/Components/sidebar-item.vue"
import {
    dashboard,
    profile,
    portal,
    logout
} from "@/utils/routes.js"

onMounted(() => {
    const { props } = usePage()
    const { role } = props.auth.user
    isAdminAccount.value = checkAdminAccount(role)
});

const isAdminAccount = ref(false)

const leftDrawerOpen = ref(true)

function toggleLeftDrawer() {
    leftDrawerOpen.value = !leftDrawerOpen.value
}
</script>

<template>
    <q-layout
        view="lhr LpR lfr"
        class="layout"
    >
        <q-header class="bg-transparent">
            <q-toolbar>
                <q-btn
                    flat
                    round
                    size="md"
                    icon="menu"
                    color="primary"
                    @click="toggleLeftDrawer"
                />

                <q-space />

                <q-btn-dropdown
                    split
                    flat
                    no-caps
                    size="md"
                    color="primary"
                    label="Профиль"
                    @click="profile"
                >
                    <q-list>
                        <q-item
                            clickable
                            v-close-popup
                            @click="portal"
                        >
                            <q-item-section>
                                <q-item-label>Портал</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item
                            v-if="isAdminAccount"
                            clickable
                            v-close-popup
                            @click="dashboard"
                        >
                            <q-item-section>
                                <q-item-label>Панель администратора</q-item-label>
                            </q-item-section>
                        </q-item>

                        <q-item
                            clickable
                            v-close-popup
                            @click="logout"
                        >
                            <q-item-section>
                                <q-item-label>Выйти</q-item-label>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-btn-dropdown>
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="leftDrawerOpen"
            show-if-above
            side="left"
            behavior="desktop"
            class="bg-sidebar"
        >
            <q-scroll-area class="fit">
                <div class="q-mb-lg q-pa-md">
                    <q-img :src="assetsImageUrl('logo.png')" />
                </div>

                <q-list>
                    <sidebar-item
                        title="Профиль пользователя"
                        @click="router.get(route('profile.index'))"
                        :active="$page.component.startsWith('Profile/Profile')"
                    />
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <div class="q-px-xl q-pb-xl">
                <slot />
            </div>
        </q-page-container>
    </q-layout>
</template>

<style scoped lang="scss">
.layout {
    :deep() {
        .q-drawer {
            background-color: var(--bg-sidebar);

            .q-item {
                color: var(--text-sidebar-level-1);
            }

            .expansion-item {
                .q-item {
                    color: var(--text-sidebar-level-2);
                }
            }
        }
    }
}
</style>

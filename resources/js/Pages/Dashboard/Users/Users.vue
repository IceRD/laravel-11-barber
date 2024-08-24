<script setup>
import { computed, ref } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import { checkAdminAccount, rolesNames } from "@utils/roles.js"
import Header from "@components/Header.vue"
import { router, Link, usePage } from "@inertiajs/vue3"


const $page = usePage()

const isSysAdmin = computed(() => $page.props.auth.isSysAdmin)

const props = defineProps({
    users: {
        type: Array,
        default: () => ([])
    },
});

const users = computed(() => {
    return (props.users || []).map(user => ({
        ...user,
        role: rolesNames[user.role]
    }))
})

const rows = computed(() => {
    switch (filterStatus.value) {
        case "active":
            return users.value.filter(user => !user.is_disabled)
        case "disable":
            return users.value.filter(user => user.is_disabled)
        default:
            return users.value
    }
})

const search = ref("")

const filterStatus = ref("active")

const statusList = [
    { "id": "all", "value": "Все" },
    { "id": "active", "value": "Активные" },
    { "id": "disable", "value": "Закблокированные" }
]

const columns = [
    { name: 'id', align: 'left', label: '#', field: 'id', sortable: true },
    { name: 'login', align: 'left', label: 'Логин', field: 'login', sortable: true },
    { name: 'name', align: 'left', label: 'Имя', field: 'name', sortable: true },
    { name: 'role', align: 'left', label: 'Роль', field: 'role', sortable: true },
    { name: 'partner_name', align: 'left', label: 'Филиал', field: 'partner_name', sortable: true },
    { name: 'is_disabled', align: 'center', label: 'Статус', field: 'is_disabled', sortable: true },
    { name: 'last_activity', align: 'left', label: 'Последняя активность', field: 'last_activity', sortable: true },
    { name: 'actions', align: 'right', label: 'Действия', field: '', sortable: false },
]

const initialPagination = {
    sortBy: 'desc',
    sortOrder: 'id',
    descending: false,
    page: 1,
    rowsPerPage: 15
}

const goToEdit = (user) => router.get(route("dashboard.users.edit", { user }))
const goToNew = () => router.get(route("dashboard.users.create"))

</script>

<template>
    <dashboard-layout>
        <Header title="Список пользователей" />

        <div class="users-view">
            <q-table
                :rows="rows"
                :columns="columns"
                :pagination="initialPagination"
                :filter="search"
                row-key="id"
                flat
                class="users-table"
            >
                <template v-slot:top>
                    <div class="row q-gutter-x-md">
                        <q-btn
                            v-if="isSysAdmin"
                            :unelevated="true"
                            color="primary"
                            no-caps
                            label="Добавить"
                            @click="goToNew"
                        />

                        <q-select
                            v-model="filterStatus"
                            :options="statusList"
                            label="Статус"
                            option-value="id"
                            option-label="value"
                            emit-value
                            map-options
                            outlined
                            dense
                            style="width: 180px"
                        />
                    </div>

                    <q-space />

                    <q-input
                        v-model="search"
                        label="Поиск"
                        outlined
                        dense
                        clearable
                        class="desktop-only"
                    />
                </template>

                <template v-slot:body="props">
                    <q-tr
                        :props="props"
                        :class="{
                            'is-admin': checkAdminAccount(props.row.role),
                            'is-disabled': props.row.is_disabled
                        }"
                    >
                        <q-td key="id" :props="props">
                            {{ props.row.id }}
                        </q-td>

                        <q-td key="login" :props="props">
                            <Link
                                :href="route('dashboard.users.edit', { user: props.row.id })"
                                method="get"
                            >
                                {{ props.row.login }}
                            </Link>
                        </q-td>

                        <q-td key="name" :props="props">
                            {{ props.row.name || "-" }}
                        </q-td>

                        <q-td key="role" :props="props">
                            {{ props.row.role || "-" }}
                        </q-td>

                        <q-td key="partner_name" :props="props">
                            <Link
                                v-if="props.row.partner_id"
                                :href="route('dashboard.partners.edit', { partner: props.row.id })"
                                method="get"
                            >
                                {{ props.row.partner_name}}
                            </Link>
                            <span v-else> - </span>
                        </q-td>

                        <q-td key="is_disabled" :props="props">
                            <q-icon
                                v-if="props.row.is_disabled"
                                name="unpublished"
                                class="text-negative"
                                size="1.1rem"
                            />
                            <q-icon
                                v-else
                                name="check_circle"
                                class="text-positive"
                                size="1.1rem"
                            />
                        </q-td>

                        <q-td key="last_activity" :props="props">
                            {{ props.row.last_activity || "-" }}
                        </q-td>

                        <q-td key="actions" :props="props">
                            <q-btn
                                flat
                                icon="edit_note"
                                size="md"
                                padding="none"
                                @click="goToEdit(props.row.id)"
                            />
                        </q-td>
                    </q-tr>
                </template>
            </q-table>
        </div>

    </dashboard-layout>
</template>

<style scoped lang="scss">
.users-view {
    .users-table {
        background-color: var(--bg-table);

        :deep() {
            thead {
                th {
                    position: sticky;
                    z-index: 1;
                    font-weight: bold;
                }

                tr:first-child th {
                    top: 0;
                    background-color: var(--bg-table);
                }
            }

            .q-table__top {
                border-bottom: 1px solid $separator-color;
            }
        }

        .is-admin {
            background-color: var(--positive-1);
        }

        .is-disabled {
            background-color: var(--negative-1);
        }
    }
}
</style>

<script setup>
import { ref} from "vue"
import { Head } from "@inertiajs/vue3"
import DashboardLayout from "@/Layouts/DashboardLayout.vue"
import {checkAdminAccount, rolesNames} from "@/utils/roles.js";

const props = defineProps({
    users: {
        type: Array,
        default: () => ([])
    },
});

const rows = ref(props.users?.data || [])

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
    rowsPerPage: 100
}
</script>

<template>
    <dashboard-layout>
        <Head title="Список пользователей" />

            <div class="users-view">
                <q-table
                    :rows="rows"
                    :columns="columns"
                    row-key="id"
                    :pagination="initialPagination"
                    flat
                    bordered
                    class="users-table"
                >
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
                                {{ props.row.login || "-" }}
                            </q-td>
                            <q-td key="name" :props="props">
                                {{ props.row.name || "-" }}
                            </q-td>
                            <q-td key="role" :props="props">
                                {{ rolesNames[props.row.role] }}
                            </q-td>
                            <q-td key="partner_name" :props="props">
                                {{ props.row.partner_name || "-" }}
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
                                {{ props.row.last_activity }}
                            </q-td>
                            <q-td key="actions" :props="props">
                                <q-btn
                                    flat
                                    icon="edit_note"
                                    size="md"
                                    padding="none"
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
        :deep() {
            th {
                font-weight: bold;
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

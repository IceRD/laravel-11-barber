<script setup>
import { computed, ref } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import { router, Link, usePage } from "@inertiajs/vue3"


const $page = usePage()

const isSysAdmin = computed(() => $page.props.auth.isSysAdmin)

const props = defineProps({
    sheets: {
        type: Array,
        default: () => ([])
    },
});

const rows = computed(() => {
    switch (filterStatus.value) {
        case "active":
            return props.sheets.filter(sheet => !sheet.disabled)
        case "disable":
            return props.sheets.filter(sheet => sheet.disabled)
        default:
            return props.sheets
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
    { name: 'title', align: 'left', label: 'Заголовок', field: 'title', sortable: true },
    { name: 'slug', align: 'left', label: 'Ссылка', field: 'slug', sortable: true },
    { name: 'disabled', align: 'center', label: 'Статус', field: 'disabled', sortable: true },
    { name: 'created_at', align: 'center', label: 'Дата создания', field: 'created_at', sortable: true },
    { name: 'actions', align: 'right', label: 'Действия', field: '', sortable: false },
]

const initialPagination = {
    sortBy: 'desc',
    sortOrder: 'id',
    descending: false,
    page: 1,
    rowsPerPage: 15
}

const goToEdit = (sheet) => router.get(route("dashboard.sheets.edit", { sheet }))
const goToNew = () => router.get(route("dashboard.sheets.create"))

</script>

<template>
    <dashboard-layout>
        <Header title="Интеграция с Google документами" />

        <div class="sheets-view">
            <q-table
                :rows="rows"
                :columns="columns"
                :pagination="initialPagination"
                :filter="search"
                row-key="id"
                flat
                class="sheets-table"
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
                            class="filter-status"
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
                            'is-disabled': props.row.disabled
                        }"
                    >
                        <q-td key="id" :props="props">
                            {{ props.row.id }}
                        </q-td>

                        <q-td key="title" :props="props">
                            <Link
                                :href="route('dashboard.sheets.edit', { sheet: props.row.id })"
                                method="get"
                            >
                                {{ props.row.title }}
                            </Link>
                        </q-td>

                        <q-td key="slug" :props="props">
                            <Link
                                :href="route('portal.sheets.index', { sheet: props.row.slug })"
                                method="get"
                            >
                                {{ props.row.slug }}
                            </Link>
                        </q-td>

                        <q-td key="disabled" :props="props">
                            <q-icon
                                v-if="props.row.disabled"
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

                        <q-td key="created_at" :props="props">
                            {{ props.row.created_at || "-" }}
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
.sheets-view {
    .filter-status {
        width: 180px;
    }

    .sheets-table {
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

        .is-disabled {
            background-color: var(--negative-1);
        }
    }
}
</style>

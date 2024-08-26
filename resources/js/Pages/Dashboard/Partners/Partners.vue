<script setup>
import { computed, ref } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import { Link, router, usePage } from "@inertiajs/vue3"
import { telnumFormat } from "@/utils/helper.js"


const $page = usePage()

const isSysAdmin = computed(() => $page.props.auth.isSysAdmin)

const props = defineProps({
    partners: {
        type: Array,
        default: () => ([])
    },
});

const partners = computed(() => {
    return (props.partners || []).map(partner => ({
        ...partner,
        telnums: telnumFormat(getFirstTelnum(partner.telnums))
    }))
})

const rows = computed(() => {
    switch (filterStatus.value) {
        case "active":
            return partners.value.filter(partner => !partner.disabled)
        case "disable":
            return partners.value.filter(partner => partner.disabled)
        default:
            return partners.value
    }
})

const filter = ref("")

const filterStatus = ref("active")

const statusList = [
    { "id": "all", "value": "Все" },
    { "id": "active", "value": "Активные" },
    { "id": "disable", "value": "Закблокированные" }
]

const columns = [
    { name: 'id', align: 'left', label: '#', field: 'id', sortable: true },
    { name: 'name', align: 'left', label: 'Название филиала', field: 'name', sortable: true },
    { name: 'organization', align: 'left', label: 'Организация', field: 'organization', sortable: true },
    { name: 'inn', align: 'left', label: 'ИНН', field: 'inn', sortable: true },
    { name: 'contract_number', align: 'left', label: 'Номер договора', field: 'contract_number', sortable: true },
    { name: 'telnums', align: 'center', label: 'Телефон филиала', field: 'telnums', sortable: true },
    { name: 'yclients_id', align: 'left', label: 'ID филиала', field: 'yclients_id', sortable: true },
    { name: 'disabled', align: 'center', label: 'Статус', field: 'disabled', sortable: true },
    { name: 'start_at', align: 'center', label: 'Дата открытия', field: 'start_at', sortable: true },
    { name: 'actions', align: 'right', label: 'Действия', field: '', sortable: false },
]

const initialPagination = {
    sortBy: 'desc',
    sortOrder: 'id',
    descending: false,
    page: 1,
    rowsPerPage: 15
}

function getFirstTelnum(string) {
    if (!string) return ""
    const telnums = JSON.parse(string)
        .filter(telnum => !!telnum.number)

    return telnums[0]?.number
}

const goToEdit = (partner) => router.get(route("dashboard.partners.edit", { partner }))
const goToNew = () => router.get(route("dashboard.partners.create"))

</script>

<template>
    <dashboard-layout>
        <Header title="Партнеры" />

        <div class="partners-view">
            <q-table
                :rows="rows"
                :columns="columns"
                :pagination="initialPagination"
                :filter="filter"
                row-key="id"
                flat
                class="partners-table"
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
                        v-model="filter"
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

                        <q-td key="name" :props="props">
                            <Link
                                :href="route('dashboard.partners.edit', { partner: props.row.id })"
                                method="get"
                            >
                                {{ props.row.name }}
                            </Link>
                        </q-td>

                        <q-td key="organization" :props="props">
                            {{ props.row.organization || "-" }}
                        </q-td>

                        <q-td key="inn" :props="props">
                            {{ props.row.inn || "-" }}
                        </q-td>

                        <q-td key="contract_number" :props="props">
                            {{ props.row.contract_number || "-" }}
                        </q-td>

                        <q-td key="telnums" :props="props">
                            {{ props.row.telnums || "-" }}
                        </q-td>

                        <q-td key="yclients_id" :props="props">
                            {{ props.row.yclients_id || "-" }}
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

                        <q-td key="start_at" :props="props">
                            {{ props.row.start_at || "-" }}
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
.partners-view {
    .filter-status {
        width: 180px;
    }

    .partners-table {
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

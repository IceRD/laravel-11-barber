<script setup>
import { computed, ref } from "vue"
import DashboardLayout from "@layouts/DashboardLayout.vue"
import Header from "@components/Header.vue"
import { Link, router } from "@inertiajs/vue3"
import { telnumFormat } from "@/utils/helper.js"
import { date } from "quasar"


const props = defineProps({
    calls: {
        type: Array,
        default: () => ([])
    },
});

const calls = computed(() => {
    return (props.calls || []).map(call => {
        return {
            ...call,
            mango_telnum: telnumFormat(call.mango_telnum),
            paymentDateExpired: call.pay_end
                ? date.getDateDiff(new Date(call.pay_end), new Date(), "days") < 0
                : false
        }
    })
})


const rows = computed(() => {
    const conditions = {
        disabled:    filterPartnerStatus,
        tg_disabled: filterStatus,
    };

    return calls.value.filter(person => {
        return Object.keys(conditions).every(key => {
            switch (conditions[key].value) {
                case "active":
                    return !!person[key] === false
                case "disable":
                    return !!person[key] === true
                default:
                    return true
            }
        });
    });
})

const filter = ref("")

const filterStatus = ref("all")

const filterPartnerStatus = ref("active")

const statusList = [
    { "id": "all", "value": "Все" },
    { "id": "active", "value": "Активные" },
    { "id": "disable", "value": "Закблокированные" }
]

const columns = [
    { name: 'id', align: 'left', label: '#', field: 'id', sortable: true },
    { name: 'partner', align: 'left', label: 'Название филиала', field: 'partner', sortable: true },
    { name: 'mango_telnum', align: 'left', label: 'Mango', field: 'mango_telnum', sortable: true },
    { name: 'tg_chat_id', align: 'left', label: 'ID чата', field: 'tg_chat_id', sortable: true },
    { name: 'new_client_days', align: 'center', label: 'Новые', field: 'new_client_days', sortable: true },
    { name: 'repeat_client_days', align: 'center', label: 'Повторные', field: 'repeat_client_days', sortable: true },
    { name: 'lost_client_days', align: 'center', label: 'Потерянные', field: 'lost_client_days', sortable: true },
    { name: 'pay_end', align: 'left', label: 'Оплачено до', field: 'pay_end', sortable: true },
    { name: 'tg_disabled', align: 'center', label: 'Статус', field: 'tg_disabled', sortable: true },
    { name: 'disabled', align: 'center', label: 'Статус партнера', field: 'disabled', sortable: true },
    { name: 'actions', align: 'right', label: 'Действия', field: '', sortable: false },
]

const initialPagination = {
    sortBy: 'desc',
    sortOrder: 'id',
    descending: false,
    page: 1,
    rowsPerPage: 15
}

const goToEdit = (call) => router.get(route("dashboard.calls.edit", { call }))

</script>

<template>
    <dashboard-layout>
        <Header title="Пропущенные звонки" />

        <div class="calls-view">
            <q-table
                :rows="rows"
                :columns="columns"
                :pagination="initialPagination"
                :filter="filter"
                row-key="id"
                flat
                class="calls-table"
            >
                <template v-slot:top>
                    <div class="row q-gutter-x-md">
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

                        <q-select
                            v-model="filterPartnerStatus"
                            :options="statusList"
                            label="Статус партнера"
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
                            'is-disabled': props.row.disabled,
                            'is-pay-end':  props.row.paymentDateExpired
                        }"
                    >
                        <q-td key="id" :props="props">
                            {{ props.row.id }}
                        </q-td>

                        <q-td key="partner" :props="props">
                            <Link
                                :href="route('dashboard.calls.edit', { call: props.row.id })"
                                method="get"
                            >
                                {{ props.row.partner }}
                            </Link>
                        </q-td>

                        <q-td key="mango_telnum" :props="props">
                            {{ telnumFormat(props.row.mango_telnum) || "-" }}
                        </q-td>

                        <q-td key="tg_chat_id" :props="props">
                            {{ props.row.tg_chat_id || "-" }}
                        </q-td>

                        <q-td key="new_client_days" :props="props">
                            {{ props.row.new_client_days || "-" }}
                        </q-td>

                        <q-td key="repeat_client_days" :props="props">
                            {{ props.row.repeat_client_days || "-" }}
                        </q-td>

                        <q-td key="lost_client_days" :props="props">
                            {{ props.row.lost_client_days || "-" }}
                        </q-td>

                        <q-td key="pay_end" :props="props">
                            {{ props.row.pay_end || "-" }}
                        </q-td>

                        <q-td key="tg_disabled" :props="props">
                            <q-icon
                                v-if="props.row.tg_disabled"
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
.calls-view {
    .filter-status {
        width: 180px;
    }

    .calls-table {
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

        .is-pay-end {
            background-color: $red-1;
        }
    }
}
</style>

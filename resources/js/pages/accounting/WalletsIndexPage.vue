<template>
    <base-table
        ref="table"
        id="wallets-table"
        :fields="fields"
        :api-method="fetchData"
        default-sort-by="name"
        :empty-text="$t('No wallets found.')"
        :items-per-page="25"
        no-filter
    >
        <template v-slot:cell(name)="data">
            <b-link
                v-if="data.item.can_update"
                :to="{ name: 'accounting.wallets.edit', params: { id: data.item.id } }"
            >
                {{ data.value }}
            </b-link>
            <template v-else>
                {{ data.value }}
            </template>
        </template>
        <template v-slot:cell(num_transactions)="data">
            <a :href="route('accounting.transactions.index', data.item)">
                {{ data.value }}
            </a>
        </template>
        <template v-slot:cell(is_default)="data">
            <font-awesome-icon :icon="data.value ? 'check' : 'times'" />
        </template>
        <template v-slot:cell(is_restricted)="data">
            <font-awesome-icon :icon="data.value ? 'check' : 'times'" />
        </template>
    </base-table>
</template>

<script>
import moment from 'moment'
import numeral from 'numeral'
import walletsApi from '@/api/accounting/wallets'
import BaseTable from '@/components/table/BaseTable'
export default {
    components: {
        BaseTable
    },
    data () {
        return {
            fields: [
                {
                    key: 'name',
                    label: this.$t('Name'),
                    sortable: true,
                },
                                {
                    key: 'amount',
                    label: this.$t('Amount'),
                    class: 'text-right',
                    formatter: value => numeral(value).format('0,0.00'),
                },
                {
                    key: 'num_transactions',
                    label: this.$t('Transactions'),
                    class: 'text-right'
                },
                {
                    key: 'is_default',
                    label: this.$t('Default'),
                    class: 'fit text-center'
                },
                {
                    key: 'is_restricted',
                    label: this.$t('Restricted'),
                    class: 'fit text-center'
                },
                {
                    key: 'latest_activity',
                    label: this.$t('Latest activity'),
                    class: 'text-right',
                    formatter: this.dateTimeFormat
                },
                {
                    key: 'created_at',
                    label: this.$t('Created'),
                    class: 'fit',
                    formatter: this.dateFormat
                }
            ]
        }
    },
    methods: {
        async fetchData (ctx) {
            return walletsApi.list(ctx)
        },
        dateFormat (value) {
            return value ? moment(value).format('LL') : null
        },
        dateTimeFormat (value) {
            return value ? moment(value).format('LLL') : null
        }
    }
}
</script>

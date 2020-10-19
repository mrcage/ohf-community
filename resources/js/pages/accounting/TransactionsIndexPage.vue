<template>
    <div>
        <base-table
            ref="table"
            id="wallet-transactons-table"
            :fields="transactionFields"
            :api-method="fetchTransactions"
            default-sort-by="created_at"
            default-sort-desc
            :empty-text="$t('app.no_data_registered')"
            :items-per-page="25"
        >
            <template v-slot:cell(receipt_pictures)="data">
                <receipt-picture-icon
                    :transacionId="data.item.id"
                    :pictures="data.value"
                />
            </template>
            <template v-slot:cell(receipt_no)="data">
                <a :href="route('accounting.transactions.show', data.item)">
                    {{ data.value }}
                </a>
            </template>
            <template v-slot:cell(supplier)="data">
                <b-link
                    v-if="data.value"
                    :to="{ name: 'accounting.suppliers.show', params: { id: data.value.slug }}"
                >
                    {{ data.value.name }}
                </b-link>
            </template>
        </base-table>
    </div>
</template>

<script>
import moment from 'moment'
import numeral from 'numeral'
import transactionsApi from '@/api/accounting/transactions'
import BaseTable from '@/components/table/BaseTable'
import ReceiptPictureIcon from '@/components/accounting/ReceiptPictureIcon'
export default {
    components: {
        BaseTable,
        ReceiptPictureIcon
    },
    props: {
        walletId: {
            required: true
        }
    },
    data () {
        return {
            transactionFields: [
                {
                    key: 'receipt_pictures',
                    label: '',
                    class: 'text-center fit'
                },
                {
                    key: 'receipt_no',
                    label: this.$t('accounting.receipt_no'),
                    sortable: true,
                    sortDirection: 'desc',
                    class: 'text-right fit'
                },
                {
                    key: 'date',
                    label: this.$t('app.date'),
                    sortable: true,
                    sortDirection: 'desc',
                    formatter: this.dateFormat,
                    class: 'text-right fit'
                },
                {
                    key: 'amount',
                    label: this.$t('app.amount'),
                    formatter: (value, key, item) => {
                        let val = value
                        if (item.type == 'spending') {
                            val = -val
                        }
                        return numeral(val).format('0,0.00')
                    },
                    class: 'text-right fit',
                    tdClass: (value, key, item) => {
                        if (item.type == 'spending') {
                            return 'text-danger'
                        }
                        return 'text-success'
                    },
                    sortable: true,
                    sortDirection: 'desc'
                },
                {
                    key: 'category',
                    label: this.$t('app.category'),
                    sortable: true
                },
                {
                    key: 'project',
                    label: this.$t('app.project'),
                    sortable: true
                },
                {
                    key: 'description',
                    label: this.$t('app.description')
                },
                {
                    key: 'attendee',
                    label: this.$t('accounting.attendee'),
                    sortable: true
                },
                {
                    key: 'supplier',
                    label: this.$t('accounting.supplier')
                },                {
                    key: 'created_at',
                    label: this.$t('app.registered'),
                    sortable: true,
                    sortDirection: 'desc',
                    formatter: this.dateTimeFormat,
                    class: 'text-right fit'
                }
            ]
        }
    },
    methods: {
        fetchTransactions (ctx) {
            return transactionsApi.list(this.walletId, ctx)
        },
        dateFormat (value) {
            return moment(value).format('LL')
        },
        dateTimeFormat (value) {
            return moment(value).format('LLL')
        }
    }
}
</script>

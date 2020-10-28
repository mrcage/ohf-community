<template>
    <b-container
        v-if="nextFreeReceiptNumber"
        fluid
        class="px-0"
    >
        <transaction-form
            :disabled="isBusy"
            :receipt-no="nextFreeReceiptNumber"
            @submit="createTransaction"
            @cancel="handleCnacel"
        />
    </b-container>
    <p v-else>
        {{ $t('app.loading') }}
    </p>
</template>

<script>
import { showSnackbar } from '@/utils'
import transactionsApi from '@/api/accounting/transactions'
import TransactionForm from '@/components/accounting/TransactionForm'
export default {
    components: {
        TransactionForm
    },
    props: {
        walletId: {
            required: true
        }
    },
    data () {
        return {
            isBusy: false,
            nextFreeReceiptNumber: null
        }
    },
    watch: {
        $route() {
            this.fetchTransaction()
        }
    },
    async created () {
        let data = await transactionsApi.nextFreeReceiptNumber(this.walletId)
        this.nextFreeReceiptNumber = data.data

    },
    methods: {
        async createTransaction (formData) {
            this.isBusy = true
            try {
                let data = await transactionsApi.store(this.walletId, formData)
                showSnackbar(this.$t('accounting.transaction_registered'))
                this.$router.push({ name: 'accounting.transactions.show', params: { id: data.data.id } })
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        },
        handleCnacel () {
            this.$router.push({ name: 'accounting.transactions.index' })
        }
    }
}
</script>

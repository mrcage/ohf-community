<template>
    <b-container
        v-if="transaction"
        fluid
        class="px-0"
    >
        <transaction-form
            :transaction="transaction"
            :disabled="isBusy"
            @submit="updateTransaction"
            @cancel="handleCnacel"
            @delete="deleteTransaction"
        />
        <hr>
        <p class="text-right">
            <small>
                {{ $t('app.last_updated') }}:
                {{ transaction.updated_at | dateTimeFormat }}
            </small>
        </p>
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
        id: {
            required: true
        }
    },
    data () {
        return {
            transaction: null,
            isBusy: false,
        }
    },
    watch: {
        $route() {
            this.fetchTransaction()
        }
    },
    async created () {
        this.fetchTransaction()
    },
    methods: {
        async fetchTransaction () {
            try {
                let data = await transactionsApi.find(this.id)
                this.transaction = data.data
            } catch (err) {
                alert(err)
            }
        },
        async updateTransaction (formData) {
            this.isBusy = true
            try {
                await transactionsApi.update(this.id, formData)
                showSnackbar(this.$t('accounting.transaction_updated'))
                this.$router.push({ name: 'accounting.transactions.show', params: { id: this.transaction.id } })
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        },
        async deleteTransaction () {
            this.isBusy = true
            try {
                await transactionsApi.delete(this.id)
                showSnackbar(this.$t('accounting.transaction_deleted'))
                this.$router.push({ name: 'accounting.transactions.index', params: { walletId: this.transaction.wallet_id } })
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        },
        handleCnacel () {
            this.$router.push({ name: 'accounting.transactions.show', params: { id: this.transaction.id } })
        }
    }
}
</script>
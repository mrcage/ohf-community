<template>
    <b-container
        v-if="transaction"
        fluid
        class="px-0"
    >
        <b-list-group class="mb-3">
            <two-col-list-group-item :title="$t('accounting.receipt')">
                {{ transaction.receipt_no }}
            </two-col-list-group-item>
            <two-col-list-group-item :title="$t('app.date')">
                {{ transaction.date | dateFormat }}
            </two-col-list-group-item>
            <two-col-list-group-item
                :title="transaction.type == 'income' ? $t('accounting.income') : $t('accounting.spending')"
            >
                <span :class="transaction.type == 'income' ? 'text-success' : 'text-danger'">
                    {{ transaction.amount | numberFormat }}
                </span>
            </two-col-list-group-item>
            <two-col-list-group-item :title="$t('app.category')">
                {{ transaction.category }}
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.secondary_category"
                :title="$t('app.secondary_category')"
            >
                {{ transaction.secondary_category }}
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.project"
                :title="$t('app.project')"
            >
                {{ transaction.project }}
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.location"
                :title="$t('app.location')"
            >
                {{ transaction.location }}
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.cost_center"
                :title="$t('accounting.cost_center')"
            >
                {{ transaction.cost_center }}
            </two-col-list-group-item>
            <two-col-list-group-item :title="$t('app.description')">
                {{ transaction.description }}
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.supplier"
                :title="$t('accounting.supplier')"
            >
                <b-link
                    v-if="transaction.can_view_supplier"
                    :to="{ name: 'accounting.suppliers.show', params: { id: transaction.supplier.slug }}"
                >
                    {{ transaction.supplier.name }}
                </b-link>
                <template v-else>
                    {{ transaction.supplier.name }}
                </template>
                <template v-if="transaction.supplier.category">
                    <br><small>{{ transaction.supplier.category }}</small>
                </template>
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.attendee"
                :title="$t('accounting.attendee')"
            >
                {{ transaction.attendee }}
            </two-col-list-group-item>
            <two-col-list-group-item
                v-if="transaction.remarks"
                :title="$t('accounting.remarks')"
            >
                {{ transaction.remarks }}
            </two-col-list-group-item>
            <two-col-list-group-item :title="$t('app.registered')">
                {{ transaction.created_at | dateTimeFormat }}
            </two-col-list-group-item>
            <two-col-list-group-item :title="$t('app.last_updated')">
                {{ transaction.updated_at | dateTimeFormat }}
            </two-col-list-group-item>
            <two-col-list-group-item :title="$t('accounting.controlled')">
                <template v-if="transaction.controlled_at">
                    {{ transaction.controlled_at | dateTimeFormat }}
                    <template v-if="transaction.controlled_by">
                        ({{ transaction.controller.name }})
                        <b-button
                            v-if="transaction.can_undo_controlling"
                            variant="secondary"
                            size="sm"
                            :disabled="isBusy"
                            @click="undoControlled"
                        >
                            {{ $t('app.undo') }}
                        </b-button>
                    </template>
                </template>
                <template v-else>
                    <b-button
                        variant="primary"
                        size="sm"
                        :disabled="isBusy"
                        @click="markControlled"
                    >
                        {{ $t('accounting.mark_controlled') }}
                    </b-button>
                </template>
            </two-col-list-group-item>

        </b-list-group>
    </b-container>
    <p v-else>
        {{ $t('app.loading') }}
    </p>
</template>

<script>
import transactionsApi from '@/api/accounting/transactions'
import TwoColListGroupItem from '@/components/ui/TwoColListGroupItem'
export default {
    components: {
        TwoColListGroupItem,
    },
    props: {
        id: {
            required: true
        }
    },
    data () {
        return {
            transaction: null,
            isBusy: false
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
        async markControlled () {
            this.isBusy = true
            try {
                let data = await transactionsApi.markControlled(this.id)
                this.transaction = data.data
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        },
        async undoControlled () {
            this.isBusy = true
            try {
                let data = await transactionsApi.undoControlled(this.id)
                this.transaction = data.data
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        }
    }
}
</script>
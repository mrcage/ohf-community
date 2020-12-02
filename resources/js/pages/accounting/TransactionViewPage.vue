<template>
    <b-container
        v-if="transaction"
        fluid
        class="px-0"
    >
        <b-row>

            <!-- Transaction details -->
            <b-col>
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
                    <two-col-list-group-item
                        v-if="transaction.fees"
                        :title="$t('accounting.fees')"
                    >
                        <span class="text-danger">
                            {{ transaction.fees | numberFormat }}
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
                        :title="$t('app.remarks')"
                    >
                        {{ transaction.remarks }}
                    </two-col-list-group-item>
                    <two-col-list-group-item :title="$t('app.registered')">
                        {{ transaction.created_at | dateTimeFormat }}
                    </two-col-list-group-item>
                    <two-col-list-group-item :title="$t('app.last_updated')">
                        {{ transaction.updated_at | dateTimeFormat }}
                    </two-col-list-group-item>

                    <!-- Controlled -->
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
                        <template v-else-if="transaction.can_update">
                            <b-button
                                variant="primary"
                                size="sm"
                                :disabled="isBusy"
                                @click="markControlled"
                            >
                                {{ $t('accounting.mark_controlled') }}
                            </b-button>
                        </template>
                        <template v-else>
                            {{ $t('app.no') }}
                        </template>
                    </two-col-list-group-item>

                    <!-- Booked -->
                    <two-col-list-group-item
                        v-if="transaction.booked"
                        :title="$t('accounting.booked')"
                    >
                        <template v-if="transaction.can_book_externally && transactions.external_id">
                            Webling:
                            <a
                                v-if="transaction.external_url"
                                :href="transaction.external_url"
                                target="_blank"
                            >
                                {{ transaction.external_id }}
                            </a>
                            <template v-else>
                                {{ transaction.external_id }}
                            </template>
                        </template>
                        <template v-else>
                            {{ $('app.yes') }}
                        </template>
                        <template v-if="transaction.can_undo_booking">
                            <p class="mb-0 mt-2">
                                <b-button
                                    type="submit"
                                    size="sm"
                                    variant="outline-danger"
                                    :disabled="isBusy"
                                    @click="undoBooking"
                                >
                                    <font-awesome-icon icon="undo"/>
                                    {{ $('accounting.undo_booking') }}
                                </b-button>
                            </p>
                        </template>
                    </two-col-list-group-item>
                </b-list-group>
            </b-col>

            <!-- Receipt pictures -->
            <b-col md="4">
                <transition-group name="list" tag="div" class="grid mb-3">
                    <template v-if="transaction.receipt_pictures.length > 0">
                        <div
                            v-for="picture in transaction.receipt_pictures"
                            :key="picture.url"
                        >
                            <template v-if="picture.thumbnail">
                                <a
                                    :href="picture.url"
                                    data-lity
                                    style="position: relative"
                                >
                                    <square-thumbnail
                                        :src="picture.thumbnail"
                                        :size="thumbnailSize"
                                    />
                                </a>
                                <b-button
                                    v-if="transaction.can_update"
                                    variant="warning"
                                    block
                                    size="sm"
                                    :style="{ width: thumbnailSize + 'px' }"
                                    :disabled="isBusy"
                                    @click="removePicture(picture.url)"
                                >
                                    <font-awesome-icon icon="trash"/>
                                    {{ $t('app.remove') }}
                                </b-button>
                            </template>
                            <span v-else>
                                <a :href="picture.url">
                                    {{ picture.mime_type }} ({{ picture.size }})
                                </a>
                            </span>
                        </div>
                    </template>
                    <div
                        v-if="transaction.can_update"
                        key="add"
                    >
                        <add-receipt-picture-button
                            :size="thumbnailSize"
                            :transaction-id="transaction.id"
                            @upload="updatePictures"
                        />
                    </div>
                </transition-group>
            </b-col>

        </b-row>
    </b-container>
    <p v-else>
        {{ $t('app.loading') }}
    </p>
</template>

<script>
import { config } from '@/plugins/laravel'
import { showSnackbar } from '@/utils'
import transactionsApi from '@/api/accounting/transactions'
import TwoColListGroupItem from '@/components/ui/TwoColListGroupItem'
import SquareThumbnail from '@/components/ui/SquareThumbnail'
import AddReceiptPictureButton from '@/components/accounting/AddReceiptPictureButton'
export default {
    components: {
        TwoColListGroupItem,
        SquareThumbnail,
        AddReceiptPictureButton
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
            thumbnailSize: config('accounting.thumbnail_size')
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
                showSnackbar(this.$t('accounting.transaction_updated'))
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
                showSnackbar(this.$t('accounting.transaction_updated'))
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        },
        async undoBooking () {
            if (!confirm(this.$t('accounting.really_undo_booking'))) {
                return
            }
            this.isBusy = true
            try {
                let data = await transactionsApi.undoBooking(this.id)
                this.transaction = data.data
                showSnackbar(this.$t('accounting.transaction_updated'))
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        },
        async updatePictures (pictures) {
            this.transaction.receipt_pictures = pictures
            showSnackbar(this.$t('accounting.transaction_updated'))
        },
        async removePicture (pictureUrl) {
            if (confirm(this.$t('app.really_remove_this_picture'))) {
                this.isBusy = true
                try {
                    let data = await transactionsApi.deleteReceipt(this.id, pictureUrl)
                    this.transaction.receipt_pictures = data
                    showSnackbar(this.$t('accounting.transaction_updated'))
                } catch (err) {
                    alert(err)
                }
                this.isBusy = false
            }
        }
    }
}
</script>

<style scoped>
.list-enter-active, .list-leave-active {
    transition: all 0.5s;
}
.list-enter, .list-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, 140px);
    grid-gap: 1rem;
}
</style>

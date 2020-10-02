<template>
    <b-container
      fluid="md"
      class="px-0"
    >
        <b-card
          v-if="showRegisterForm"
          body-class="pb-0"
          class="mb-4"
          header-class="d-flex justify-content-between"
        >
            <template v-slot:header>
                <span>{{ $t('app.check_in') }}</span>
                <b-button
                    variant="link"
                    size="sm"
                    @click="showRegisterForm = false"
                >
                    <font-awesome-icon icon="times" />
                </b-button>
            </template>
            <register-visitor-form
                :disabled="isBusy"
                @submit="registerVisitor"
            />
        </b-card>
        <b-row
            v-if="!showRegisterForm"
            class="mb-4"
        >
            <b-col>
                <b-button
                    variant="primary"
                    @click="showRegisterForm = true"
                >
                    <font-awesome-icon icon="sign-in-alt"/>
                    {{ $t('app.check_in') }}
                </b-button>
            </b-col>
            <b-col class="text-right">
                <b-dropdown
                    class="d-block d-md-none"
                    right
                    :text="$t('app.actions')"
                >
                    <b-dropdown-item
                        v-if="count !== 0"
                        @click="checkoutAll"
                    >
                        <font-awesome-icon icon="door-closed"/>
                        {{ $t('app.checkout_everyone') }}
                    </b-dropdown-item>
                    <b-dropdown-item
                      :to="{ name: 'visitors.report' }"
                    >
                        <font-awesome-icon icon="chart-bar"/>
                        {{ $t('app.report') }}
                    </b-dropdown-item>
                </b-dropdown>
                <span class="d-none d-md-inline">
                    <b-button
                        variant="secondary"
                        :to="{ name: 'visitors.report' }"
                    >
                        <font-awesome-icon icon="chart-bar"/>
                        {{ $t('app.report') }}
                    </b-button>
                    <b-button
                        v-if="count !== 0"
                        variant="secondary"
                        :disabled="isBusy"
                        @click="checkoutAll"
                    >
                        <font-awesome-icon icon="door-closed"/>
                        {{ $t('app.checkout_everyone') }}
                    </b-button>
                </span>
            </b-col>
        </b-row>
        <h3>{{ $t('visitors.current_visitors') }}</h3>
        <p class="text-muted">
            <span v-for="(v, k) in currentlyVisiting" :key="k">
                {{ getTypeLabel(k) }}: <strong>{{ v }}</strong>,
            </span>
            {{ $t('app.total') }}: <strong>{{ count }}</strong>
        </p>
        <base-table
            ref="table"
            id="visitors-table"
            :fields="fields"
            :api-method="fetchData"
            default-sort-by="entered_at"
            default-sort-desc
            :empty-text="$t('app.no_data_registered')"
            :items-per-page="100"
            @metadata="currentlyVisiting = $event.currently_visiting"
        >
            <template v-slot:cell(checkout)="data">
                <b-button
                  size="sm"
                  variant="primary"
                  :disabled="isBusy"
                  @click="checkoutVisitor(data.item.id)"
                >
                    <font-awesome-icon icon="sign-out-alt"/>
                    {{ $t('app.checkout') }}
                </b-button>
            </template>
        </base-table>
    </b-container>
</template>

<script>
import moment from 'moment'
import showSnackbar from '@/snackbar'
import visitorsApi from '@/api/visitors'
import RegisterVisitorForm from '@/components/visitors/RegisterVisitorForm'
import BaseTable from '@/components/table/BaseTable'
export default {
    components: {
        RegisterVisitorForm,
        BaseTable
    },
    data () {
        return {
            isBusy: false,
            showRegisterForm: false,
            fields: [
                {
                    key: 'last_name',
                    label: this.$t('app.last_name'),
                    sortable: true,
                    tdClass: 'align-middle'
                },
                {
                    key: 'first_name',
                    label: this.$t('app.first_name'),
                    sortable: true,
                    tdClass: 'align-middle'
                },
                {
                    key: 'type',
                    label: this.$t('app.type'),
                    tdClass: 'align-middle',
                    formatter: this.getTypeLabel,
                },
                {
                    key: 'additional_info',
                    label: this.$t('app.additional_info'),
                    tdClass: 'align-middle',
                    formatter: (value, key, item) => {
                        const items = Array()
                        if (item.id_number) {
                            items.push(`${this.$t('app.id_number')}: ${item.id_number}`)
                        }
                        if (item.place_of_residence) {
                            items.push(`${this.$t('app.place_of_residence')}: ${item.place_of_residence}`)
                        }
                        if (item.activity) {
                            items.push(`${this.$t('visitors.activity_program')}: ${item.activity}`)
                        }
                        if (item.organization) {
                            items.push(`${this.$t('app.organization')}: ${item.organization}`)
                        }
                        return items.join(', ')
                    }
                },
                {
                    key: 'entered_at',
                    label: this.$t('app.time'),
                    sortable: true,
                    sortDirection: 'desc',
                    tdClass: 'align-middle',
                    formatter: value => {
                        return moment(value).format('HH:mm')
                    },
                    class: 'fit'
                },
                {
                    key: 'checkout',
                    label: this.$t('app.checkout'),
                    class: 'fit'
                }
            ],
            currentlyVisiting: {}
        }
    },
    computed: {
        count () {
            return Object.values(this.currentlyVisiting).reduce((a, b) => a + b, 0)
        }
    },
    methods: {
        async fetchData (ctx) {
            return visitorsApi.listCurrent(ctx)
        },
        async registerVisitor (formData) {
            this.isBusy = true
            try {
                await visitorsApi.checkin(formData)
                showSnackbar(this.$t('app.checked_in'))
                this.isBusy = false
                this.$refs.table.refresh()
            } catch (err) {
                alert(err)
                this.isBusy = false
            }
        },
        async checkoutVisitor(id) {
            this.isBusy = true
            try {
                await visitorsApi.checkout(id)
                this.isBusy = false
                showSnackbar(this.$t('app.checked_out'))
                this.$refs.table.refresh()
            } catch (err) {
                alert(err)
                this.isBusy = false
            }
        },
        async checkoutAll() {
            if (confirm(this.$t('app.really_checkout_everyone'))) {
                this.isBusy = true
                try {
                    await visitorsApi.checkoutAll()
                    this.isBusy = false
                    showSnackbar(this.$t('app.everyone_checked_out'))
                    this.$refs.table.refresh()
                } catch (err) {
                    alert(err)
                    this.isBusy = false
                }
            }
        },
        getTypeLabel (value) {
            if (value == 'visitor') {
                return this.$t('visitors.visitor')
            }
            if (value == 'visitors') {
                return this.$t('visitors.visitors')
            }
            if (value == 'participant') {
                return this.$t('visitors.participant')
            }
            if (value == 'participants') {
                return this.$t('visitors.participants')
            }
            if (value == 'staff') {
                return this.$t('visitors.volunteer_staff')
            }
            if (value == 'external') {
                return this.$t('visitors.external_visitor')
            }
            return value
        }
    }
}
</script>
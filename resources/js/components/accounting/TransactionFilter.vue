<template>
    <span>
        <b-button
            v-if="hasFilter"
            variant="primary"
            size="sm"
            @click="resetFilter"
        >
            <font-awesome-icon icon="eraser"/>
            {{ $t('app.reset_filter') }}
        </b-button>
        <b-button
            variant="secondary"
            size="sm"
            v-b-modal.filter-modal
        >
            <font-awesome-icon icon="search"/>
            {{ hasFilter ? $t('app.edit_filter') : $t('app.filter_results') }}
        </b-button>
        {{ filter }}
        <b-modal
            id="filter-modal"
            :title="$t('app.filter')"
            ok-only
            :ok-title="$t('app.apply')"
            body-class="pb-0"
            @ok="handleOk"
        >
            <b-form ref="form" @submit.stop.prevent="handleSubmit">
                <b-form-row>
                    <b-col sm>
                        <b-form-group :label="$t('app.type')">
                            <b-form-radio-group
                                v-model="form.type"
                                :options="types"
                                stacked
                            />
                        </b-form-group>
                    </b-col>
                    <b-col sm class="mb-3">
                        <b-form-group :label="$t('accounting.controlled')">
                            <b-form-radio-group
                                v-model="form.controlled"
                                :options="yesNoAnyOptions"
                                stacked
                            />
                        </b-form-group>
                    </b-col>
                    <b-col sm>
                        <b-form-group :label="$t('accounting.receipt_no')">
                            <b-form-input
                                v-model="form.receipt_no"
                                autocomplete="off"
                                type="number"
                                min="1"
                            />
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-form-row>
                    <b-col sm>
                        <b-form-group :label="$t('app.from')">
                            <b-form-input
                                v-model="form.date_start"
                                autocomplete="off"
                                type="date"
                                :max="form.date_end ? form.date_end : todayDate"
                                pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                            />
                        </b-form-group>
                    </b-col>
                    <b-col sm>
                        <b-form-group :label="$t('app.to')">
                            <b-form-input
                                v-model="form.date_end"
                                autocomplete="off"
                                type="date"
                                :min="form.date_start"
                                :max="todayDate"
                                pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                            />
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-form-row>
                    <b-col sm>
                        <taxonomy-select
                            v-model="form.category"
                            name="category"
                            :label="$t('app.category')"
                            :options="categories"
                            :fixed="fixedCategories"
                            allow-empty
                        />
                    </b-col>
                    <b-col v-if="secondaryCategoriesEnabled" sm>
                        <taxonomy-select
                            v-model="form.secondary_category"
                            name="secondary_category"
                            :label="$t('app.secondary_category')"
                            :options="secondaryCategories"
                            :fixed="fixedSecondaryCategories"
                            allow-empty
                        />
                    </b-col>
                    <b-col sm>
                        <taxonomy-select
                            v-model="form.project"
                            name="project"
                            :label="$t('app.project')"
                            :options="projects"
                            :fixed="fixedProjects"
                            allow-empty
                        />
                    </b-col>
                </b-form-row>
                <b-form-row>
                    <b-col v-if="locationsEnabled" sm>
                        <taxonomy-select
                            v-model="form.location"
                            name="location"
                            :label="$t('app.location')"
                            :options="locations"
                            :fixed="fixedLocations"
                            allow-empty
                        />
                    </b-col>
                    <b-col v-if="costCentersEnabled" sm>
                        <taxonomy-select
                            v-model="form.cost_center"
                            name="cost_center"
                            :label="$t('accounting.cost_center')"
                            :options="costCenters"
                            :fixed="fixedCostCenters"
                            allow-empty
                        />
                    </b-col>
                </b-form-row>
                <b-form-row>
                    <b-col sm>
                        <b-form-group :label="$t('accounting.attendee')">
                            <b-form-input
                                v-model="form.attendee"
                                autocomplete="off"
                                list="attendee-list"
                            />
                        </b-form-group>
                        <b-form-datalist id="attendee-list" :options="attendees"/>
                    </b-col>
                    <b-col sm>
                        <b-form-group :label="$t('app.description')">
                            <b-form-input
                                v-model="form.description"
                                autocomplete="off"
                            />
                        </b-form-group>
                    </b-col>
                </b-form-row>
                <b-form-row>
                    <b-col v-if="hasSuppliers" sm>
                        <b-form-group :label="$t('accounting.supplier')">
                            <b-form-input
                                v-model="form.supplier"
                                autocomplete="off"
                                list="supplier-list"
                            />
                        </b-form-group>
                        <b-form-datalist id="supplier-list" :options="suppliers"/>
                    </b-col>
                    <b-col sm :class="{ 'pt-4': hasSuppliers }">
                        <b-form-checkbox
                            v-model="form.today"
                        >
                            {{ $t('accounting.registered_today') }}
                        </b-form-checkbox>
                        <b-form-checkbox
                            v-model="form.no_receipt"
                        >
                            {{ $t('accounting.no_receipt') }}
                        </b-form-checkbox>
                    </b-col>
                </b-form-row>
            </b-form>
        </b-modal>
    </span>
</template>

<script>
import transactionsApi from '@/api/accounting/transactions'
import suppliersApi from '@/api/accounting/suppliers'
import TaxonomySelect from '@/components/accounting/TaxonomySelect'
export default {
    components: {
        TaxonomySelect
    },
    props: {
        value: {
            required: true,
            type: Object
        }
    },
    data () {
        return {
            form: {
                type: this.value.type,
                controlled: this.value.controlled,
                receipt_no: this.value.receipt_no,
                date_start: this.value.date_start,
                date_end: this.value.date_end,
                category: this.value.category,
                secondary_category: this.value.secondary_category,
                project: this.value.project,
                location: this.value.location,
                cost_center: this.value.cost_center,
                attendee: this.value.attendee,
                description: this.value.description,
                supplier: this.value.supplier,
                today: this.value.today,
                no_receipt: this.value.no_receipt,
            },
            types: [
                { value: 'income', text: this.$t('accounting.income')},
                { value: 'spending', text: this.$t('accounting.spending')},
                { value: null, text: this.$t('app.any')}
            ],
            yesNoAnyOptions: [
                { value: 'yes', text: this.$t('app.yes')},
                { value: 'no', text: this.$t('app.no')},
                { value: null, text: this.$t('app.any')},
            ],
            categories: [],
            fixedCategories: false,
            secondaryCategories: [],
            secondaryCategoriesEnabled: false,
            fixedSecondaryCategories: false,
            projects: [],
            fixedProjects: false,
            locations: [],
            fixedLocations: false,
            locationsEnabled: false,
            costCenters: [],
            fixedCostCenters: false,
            costCentersEnabled: false,
            attendees: [],
            suppliers: [],
        }
    },
    computed: {
        filter: {
            get () {
                return this.value
            },
            set (value) {
                this.$emit('input', value)
            }
        },
        hasFilter () {
            return Object.keys(this.filter).length > 0
        },
        todayDate () {
            const today = new Date().toISOString().slice(0, 10)
            return today
        },
        hasSuppliers () {
            return this.suppliers.length > 0
        }
    },
    async created () {
        this.fetchCategories()
        this.fetchSecondaryCategories()
        this.fetchProjects()
        this.fetchLocations()
        this.fetchCostCenters()
        this.fetchAttendees()
        this.fetchSuppliers()
    },
    methods: {
        async fetchCategories() {
            let data = await transactionsApi.categories()
            this.categories = data.data
            this.fixedCategories = data.meta.fixed
        },
        async fetchSecondaryCategories() {
            let data = await transactionsApi.secondaryCategories()
            this.secondaryCategories = data.data
            this.fixedSecondaryCategories = data.meta.fixed
            this.secondaryCategoriesEnabled = data.meta.enabled
        },
        async fetchProjects() {
            let data = await transactionsApi.projects()
            this.projects = data.data
            this.fixedProjects = data.meta.fixed
        },
        async fetchLocations() {
            let data = await transactionsApi.locations()
            this.locations = data.data
            this.fixedLocations = data.meta.fixed
            this.locationsEnabled = data.meta.enabled
        },
        async fetchCostCenters() {
            let data = await transactionsApi.costCenters()
            this.costCenters = data.data
            this.fixedCostCenters = data.meta.fixed
            this.costCentersEnabled = data.meta.enabled
        },
        async fetchAttendees() {
            let data = await transactionsApi.attendees()
            this.attendees = data.data
        },
        async fetchSuppliers() {
            let data = await suppliersApi.list({ mode: 'selectlist' })
            this.suppliers = data.data.map(e => e.name)
        },
        handleOk(bvModalEvt) {
            bvModalEvt.preventDefault()
            this.handleSubmit()
        },
        handleSubmit() {
            this.applyFilter()
            this.$nextTick(() => this.$bvModal.hide('filter-modal'))
        },
        applyFilter () {
            this.filter = Object.fromEntries(
                Object.keys(this.form)
                    .filter(k => this.form[k])
                    .map(k => [k, this.form[k]])
            )
        },
        resetFilter () {
            this.filter = {}
        }
    }
}
</script>

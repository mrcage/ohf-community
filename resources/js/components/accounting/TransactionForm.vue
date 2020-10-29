<template>
    <validation-observer
        ref="observer"
        v-slot="{ handleSubmit }"
        slim
    >
        <b-form @submit.stop.prevent="handleSubmit(onSubmit)">

            <b-form-row>

                <!-- Receipt Number -->
                <b-col sm="auto">
                    <validation-provider
                        :name="$t('app.date')"
                        vid="receipt_no"
                        :rules="{ required: true }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('accounting.receipt_no')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                            class="required-marker"
                        >
                            <b-form-input
                                v-model="form.receipt_no"
                                autocomplete="off"
                                type="number"
                                min="1"
                                required
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

                <!-- Date -->
                <b-col sm>
                    <validation-provider
                        :name="$t('app.date')"
                        vid="date"
                        :rules="{ required: true }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.date')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                            class="required-marker"
                        >
                            <b-form-input
                                v-model="form.date"
                                autocomplete="off"
                                type="date"
                                required
                                pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

                <!-- Type -->
                <b-col sm="auto" class="pb-3">
                    <validation-provider
                        :name="$t('app.type')"
                        vid="type"
                        :rules="{ required: true }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.type')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                            class="required-marker"
                        >
                            <b-form-radio-group
                                v-model="form.type"
                                :options="types"
                                stacked
                                required
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

                <!-- Amount -->
                <b-col sm>
                    <validation-provider
                        :name="$t('app.amount')"
                        vid="amount"
                        :rules="{ required: true }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.amount')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                            :description="$t('app.write_decimal_point_as_comma')"
                            class="required-marker"
                        >
                            <b-form-input
                                v-model="form.amount"
                                autocomplete="off"
                                type="number"
                                min="0"
                                step="any"
                                required
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

            </b-form-row>

            <b-form-row>

                <!-- Attendee -->
                <b-col sm>
                    <validation-provider
                        :name="$t('accounting.attendee')"
                        vid="attendee"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('accounting.attendee')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-input
                                v-model="form.attendee"
                                autocomplete="off"
                                 list="attendee-list"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                        <b-form-datalist id="attendee-list" :options="attendees"/>
                    </validation-provider>
                </b-col>

                <!-- Category -->
                <b-col sm>
                    <validation-provider
                        :name="$t('app.category')"
                        vid="category"
                        :rules="{ required: true }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.category')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                            class="required-marker"
                        >
                            <b-form-select
                                v-if="fixedCategories"
                                v-model="form.category"
                                :options="categories"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-input
                                v-else
                                v-model="form.category"
                                autocomplete="off"
                                list="category-list"
                                required
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                        <b-form-datalist
                            v-if="! fixedCategories"
                            id="category-list"
                            :options="categories"
                        />
                    </validation-provider>
                </b-col>

            </b-form-row>

            <b-form-row>

                <!-- Secondary category -->
                <b-col
                    v-if="secondaryCategoriesEnabled"
                    sm
                >
                    <validation-provider
                        :name="$t('app.secondary_category')"
                        vid="secondary_category"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.secondary_category')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-select
                                v-if="fixedSecondaryCategories"
                                v-model="form.secondary_category"
                                :options="[''].concat(secondaryCategories)"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-input
                                v-else
                                v-model="form.secondary_category"
                                autocomplete="off"
                                list="secondary-categories-list"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                        <b-form-datalist
                            v-if="! fixedSecondaryCategories"
                            id="secondary-categories-list"
                            :options="secondaryCategories"
                        />
                    </validation-provider>
                </b-col>

                <!-- Project -->
                <b-col sm>
                    <validation-provider
                        :name="$t('app.project')"
                        vid="project"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.project')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-select
                                v-if="fixedProjects"
                                v-model="form.project"
                                :options="[''].concat(projects)"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-input
                                v-else
                                v-model="form.project"
                                autocomplete="off"
                                list="project-list"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                        <b-form-datalist
                            v-if="! fixedProjects"
                            id="project-list"
                            :options="projects"
                        />
                    </validation-provider>
                </b-col>

            </b-form-row>

            <b-form-row>

                <!-- Location -->
                <b-col
                    v-if="locationsEnabled"
                    sm
                >
                    <validation-provider
                        :name="$t('app.location')"
                        vid="location"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.location')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-select
                                v-if="fixedLocations"
                                v-model="form.location"
                                :options="[''].concat(locations)"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-input
                                v-else
                                v-model="form.location"
                                autocomplete="off"
                                list="locations-list"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                        <b-form-datalist
                            v-if="! fixedLocations"
                            id="locations-list"
                            :options="locations"
                        />
                    </validation-provider>
                </b-col>

                <!-- Cost center -->
                <b-col
                    v-if="costCentersEnabled"
                    sm
                >
                    <validation-provider
                        :name="$t('accounting.cost_center')"
                        vid="cost_center"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('accounting.cost_center')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-select
                                v-if="fixedCostCenters"
                                v-model="form.cost_center"
                                :options="[''].concat(costCenters)"
                                :state="getValidationState(validationContext)"
                            />
                            <b-form-input
                                v-else
                                v-model="form.cost_center"
                                autocomplete="off"
                                list="cost-centers-list"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                        <b-form-datalist
                            v-if="! fixedCostCenters"
                            id="cost-centers-list"
                            :options="costCenters"
                        />
                    </validation-provider>
                </b-col>

            </b-form-row>

            <b-form-row>

                <!-- Description -->
                <b-col sm>
                    <validation-provider
                        :name="$t('app.description')"
                        vid="description"
                        :rules="{ required: true }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.description')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                            class="required-marker"
                        >
                            <b-form-input
                                v-model="form.description"
                                autocomplete="off"
                                required
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

                <!-- Supplier -->
                <b-col
                    v-if="suppliers.length > 0"
                    sm
                >
                    <validation-provider
                        :name="$t('accounting.supplier')"
                        vid="supplier"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('accounting.supplier')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-select
                                v-model="form.supplier_id"
                                :options="suppliers"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

            </b-form-row>

            <b-form-row>

                <!-- Remarks -->
                <b-col sm>
                    <validation-provider
                        :name="$t('app.remarks')"
                        vid="remarks"
                        :rules="{ }"
                        v-slot="validationContext"
                    >
                        <b-form-group
                            :label="$t('app.remarks')"
                            :state="getValidationState(validationContext)"
                            :invalid-feedback="validationContext.errors[0]"
                        >
                            <b-form-input
                                v-model="form.remarks"
                                autocomplete="off"
                                :state="getValidationState(validationContext)"
                            />
                        </b-form-group>
                    </validation-provider>
                </b-col>

            </b-form-row>

            <p class="d-flex justify-content-between align-items-start">
                <span>
                    <!-- Submit -->
                    <b-button
                        type="submit"
                        variant="primary"
                        :disabled="disabled"
                    >
                        <font-awesome-icon icon="check" />
                        {{ transaction ? $t('app.update') : $t('app.add') }}
                    </b-button>

                    <!-- Cancel -->
                    <b-button
                        variant="link"
                        :disabled="disabled"
                        @click="$emit('cancel')"
                    >
                        {{ $t('app.cancel') }}
                    </b-button>
                </span>

                <!-- Delete -->
                <b-button
                    v-if="transaction && transaction.can_delete"
                    variant="link"
                    :disabled="disabled"
                    class="text-danger"
                    @click="onDelete"
                >
                    {{ $t('app.delete') }}
                </b-button>

            </p>
        </b-form>
    </validation-observer>
</template>

<script>
import moment from 'moment'
import transactionsApi from '@/api/accounting/transactions'
import suppliersApi from '@/api/accounting/suppliers'
export default {
    props: {
        transaction: {
            type: Object,
            required: false
        },
        disabled: Boolean,
        receiptNo: {
            required: false,
            type: Number,
            default: null
        }
    },
    data () {
        return {
            form: this.transaction ? {
                receipt_no: this.transaction.receipt_no,
                date: this.transaction.date,
                type: this.transaction.type,
                amount: this.transaction.amount,
                attendee: this.transaction.attendee,
                category: this.transaction.category,
                secondary_category: this.transaction.secondary_category,
                project: this.transaction.project,
                location: this.transaction.location,
                cost_center: this.transaction.cost_center,
                description: this.transaction.description,
                supplier_id: this.transaction.supplier_id,
                remarks: this.transaction.remarks,
            } : {
                receipt_no: this.receiptNo,
                date: moment().format('YYYY-MM-DD'),
                type: 'spending',
                amount: null,
                attendee: null,
                category: null,
                secondary_category: null,
                project: null,
                location: null,
                cost_center: null,
                description: null,
                supplier_id: null,
                remarks: null,
            },
            types: [
                { value: 'income', text: this.$t('accounting.income') },
                { value: 'spending', text: this.$t('accounting.spending') },
            ],
            attendees: [],
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
            suppliers: [],
        }
    },
    async created () {
        this.fetchAttendees()
        this.fetchCategories()
        this.fetchSecondaryCategories()
        this.fetchProjects()
        this.fetchLocations()
        this.fetchCostCenters()
        this.fetchSuppliers()
    },
    methods: {
        async fetchAttendees() {
            let data = await transactionsApi.attendees()
            this.attendees = data.data
        },
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
        async fetchSuppliers() {
            let data = await suppliersApi.list({ mode: 'selectlist' })
            this.suppliers = data.data.map(e => ({
                value: e.id,
                text: e.name + (e.category ? ` (${e.category})` : '')
            }))
            this.suppliers.unshift({
                value: null,
                text: `- ${this.$t('accounting.supplier')} -`
            })
        },
        getValidationState ({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        onSubmit () {
            this.$emit('submit', this.form)
        },
        onDelete () {
            if (confirm(this.$t('accounting.confirm_delete_transaction'))) {
                this.$emit('delete')
            }
        }
    }
}
</script>

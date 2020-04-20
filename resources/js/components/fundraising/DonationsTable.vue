<template>
    <base-table
        id="donationsTable"
        :fields="fields"
        :api-url="apiUrl"
        default-sort-by="created_at"
        default-sort-desc
        :empty-text="$t('fundraising.no_donations_found')"
        :filter-placeholder="$t('app.search_ellipsis')"
        :items-per-page="100"
        :loading-label="$t('app.loading')"
    >
        <template v-slot:cell(date)="data">
            <a :href="data.item.edit_url" v-if="data.value != ''">{{ data.value }}</a>
        </template>
        <template v-slot:cell(donor)="data">
            <a :href="data.item.donor_url" v-if="data.value != ''">{{ data.value }}</a>
        </template>
        <template v-slot:head(thanked)>
            <font-awesome-icon icon="handshake" />
        </template>
        <template v-slot:cell(thanked)="data">
            <font-awesome-icon v-if="data.value" icon="check" />
        </template>
    </base-table>
</template>

<script>
import BaseTable from '@/components/BaseTable'
export default {
    components: {
        BaseTable
    },
    props: {
        apiUrl: {
            required: true,
            type: String
        },
    },
    data() {
        return {
            fields: [
                {
                    key: 'date',
                    label: this.$t('app.date'),
                    class: 'fit',
                    sortable: true
                },
                {
                    key: 'amount',
                    label: this.$t('app.amount'),
                    class: 'text-right fit',
                    sortable: true
                },
                {
                    key: 'donor',
                    label: this.$t('fundraising.donor'),
                    sortable: false
                },
                {
                    key: 'channel',
                    label: this.$t('fundraising.channel'),
                    class: 'd-none d-sm-table-cell',
                    sortable: false
                },
                {
                    key: 'purpose',
                    label: this.$t('fundraising.purpose'),
                    sortable: false
                },
                {
                    key: 'reference',
                    label: this.$t('fundraising.reference'),
                    class: 'd-none d-sm-table-cell',
                    sortable: false
                },
                {
                    key: 'in_name_of',
                    label: this.$t('fundraising.in_name_of'),
                    class: 'd-none d-sm-table-cell',
                    sortable: true
                },
                {
                    key: 'created_at',
                    label: this.$t('app.registered'),
                    class: 'd-none d-sm-table-cell fit',
                    sortable: true
                },
                {
                    key: 'thanked',
                    label: this.$t('fundraising.thanked'),
                    class: 'fit',
                    sortable: false
                }
            ]
        }
    }
}
</script>
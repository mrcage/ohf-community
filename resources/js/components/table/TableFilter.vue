<template>
    <b-input-group class="mb-3">
        <b-form-input
            v-model="filterText"
            :debounce="400"
            trim
            type="search"
            :placeholder="placeholder"
            autocomplete="off"
            @keyup.esc="filterText = ''"
        ></b-form-input>
        <b-input-group-append class="d-none d-sm-block">
            <b-input-group-text v-if="isBusy">
                ...
            </b-input-group-text>
            <b-input-group-text v-else>
                {{ $t('{num} results', { num: totalRows }) }}
            </b-input-group-text>
        </b-input-group-append>
    </b-input-group>
</template>

<script>
export default {
    props: {
        value: {
            required: true,
        },
        placeholder: {
            required: false,
            type: String,
            default: function() {
                return this.$t('Type to search...')
            }
        },
        totalRows: {
            type: Number
        },
        isBusy: Boolean,
    },
    computed: {
        filterText: {
            get () {
                return this.value
            },
            set (value) {
                this.$emit('input', value)
            }
        }
    }
}
</script>

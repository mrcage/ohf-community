<template>
    <b-form-group :label="label">
        <b-form-select
            v-if="fixed"
            v-model="localValue"
            :required="required"
            :options="allowEmpty ? [''].concat(options) : options"
        />
        <template v-else>
            <b-form-input
                v-model="localValue"
                autocomplete="off"
                :required="required"
                :list="`${name}-list`"
            />
            <b-form-datalist
                :id="`${name}-list`"
                :options="options"
            />
        </template>
    </b-form-group>
</template>

<script>
export default {
    props: {
        name: {
            required: true,
            type: String
        },
        label: {
            required: true,
            type: String
        },
        value: {
            required: true
        },
        options: {
            required: true,
            type: Array,
        },
        fixed: Boolean,
        required: Boolean,
        allowEmpty: Boolean
    },
    computed: {
        localValue: {
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

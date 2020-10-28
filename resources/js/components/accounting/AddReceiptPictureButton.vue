<template>
    <span>
        <b-button
            variant="secondary"
            size="lg"
            :style="{ width: size + 'px', height: size + 'px' }"
            :disabled="isBusy"
            @click.prevent="$refs.file.click()"
        >
            <font-awesome-icon
                :icon="isBusy ? 'spinner' : 'plus-circle'"
                :spin="isBusy"
            />
        </b-button>
        <input
            ref="file"
            type="file"
            accept="image/*,application/pdf"
            multiple
            class="d-none"
            @change="doUpload"
        />
    </span>
</template>

<script>
import transactionsApi from '@/api/accounting/transactions'
export default {
    props: {
        transactionId: {
            required: true
        },
        size: {
            required: true,
            type: Number
        }
    },
    data () {
        return {
            isBusy: false
        }
    },
    methods: {
        async doUpload () {
            const files = this.$refs.file.files
            this.isBusy = true
            try {
                let data = await transactionsApi.addReceipt(this.transactionId, files)
                this.$emit('upload', data)
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        }
    }
}
</script>

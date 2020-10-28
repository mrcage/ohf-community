<template>
    <font-awesome-icon
        v-if="isBusy"
        icon="spinner"
        spin
    />
    <a
        v-else-if="pics.length > 0"
        :href="pics[0].url"
        data-lity
    >
        <font-awesome-icon :icon="icon"/>
    </a>
    <span v-else-if="allowUpload">
        <a
            href="#"
            class="text-warning"
            @click.prevent="$refs.file.click()"
        >
            <font-awesome-icon icon="plus-circle"/>
        </a>
        <input
            ref="file"
            type="file"
            accept="image/*,application/pdf"
            multiple
            class="d-none"
            @change="doUpload"
        />
    </span>
    <span v-else class="text-muted">
        <font-awesome-icon icon="camera"/>
    </span>
</template>

<script>
import transactionsApi from '@/api/accounting/transactions'
export default {
    props: {
        transactionId: {
            required: true
        },
        pictures: {
            required: false,
            type: Array,
            default: () => []
        },
        allowUpload: Boolean
    },
    data () {
        return {
            isBusy: false,
            pics: this.pictures
        }
    },
    computed: {
        icon () {
            return this.pics.length > 1 ? 'images' : 'image'
        }
    },
    methods: {
        async doUpload () {
            const files = this.$refs.file.files
            this.isBusy = true
            try {
                let data = await transactionsApi.addReceipt(this.transactionId, files)
                this.pics = data
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        }
    }
}
</script>

<template>
    <font-awesome-icon
        v-if="isBusy"
        icon="spinner"
        spin
    />
    <a
        v-else-if="urls.length > 0"
        :href="urls[0]"
        data-lity
    >
        <font-awesome-icon :icon="icon"/>
    </a>
    <span v-else>
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
</template>

<script>
import transactionsApi from '@/api/accounting/transactions'
export default {
    props: {
        transacionId: {
            required: true
        },
        pictures: {
            required: false,
            type: Array,
            default: () => []
        }
    },
    data () {
        return {
            isBusy: false,
            urls: this.pictures
        }
    },
    computed: {
        icon () {
            return this.urls.length > 1 ? 'images' : 'image'
        }
    },
    methods: {
        async doUpload () {
            const files = this.$refs.file.files
            this.isBusy = true
            try {
                let data = await transactionsApi.updateReceipt(this.transacionId, files)
                this.urls = data
            } catch (err) {
                alert(err)
            }
            this.isBusy = false
        }
    }
}
</script>
<template>
    <font-awesome-icon
        v-if="isBusy"
        icon="spinner"
        spin
    />
    <span v-else-if="pics.length > 0">
        <a
            :href="pics[0].url"
            @click.prevent="openLightbox"
        >
            <font-awesome-icon :icon="icon"/>
        </a>
        <fs-lightbox
            :toggler="toggler"
            :sources="lightboxSources"
        />
    </span>
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
import IframeSource from '@/components/IframeSource'
import FsLightbox from "fslightbox-vue"
export default {
    components: {
        FsLightbox
    },
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
            pics: this.pictures,
            toggler: false,
        }
    },
    computed: {
        icon () {
            return this.pics.length > 1 ? 'images' : 'image'
        },
        lightboxSources () {
            return this.pics.map(picture => {
                    if (picture.mime_type.startsWith('image/')) {
                        return picture.url
                    }
                    return {
                        component: IframeSource,
                        props: { source: picture.url }
                    }
                })
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
        },
        openLightbox() {
            this.toggler = !this.toggler
        }
    }
}
</script>

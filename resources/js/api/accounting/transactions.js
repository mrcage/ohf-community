import { api, route } from '@/api/baseApi'
export default {
    async list (walletId, params) {
        const url = route('api.accounting.transactions.index', { wallet: walletId, ...params })
        return await api.get(url)
    },
    async store (walletId, data) {
        const url = route('api.accounting.transactions.store', walletId)
        return await api.post(url, data)
    },
    async find (id, params = {}) {
        let url = route('api.accounting.transactions.show', { transaction: id, ...params })
        return await api.get(url)
    },
    async update (id, data) {
        const url = route('api.accounting.transactions.update', id)
        return await api.put(url, data)
    },
    async delete (id) {
        const url = route('api.accounting.transactions.destroy', id)
        return await api.delete(url)
    },
    async addReceipt (id, files) {
        const url = route('api.accounting.transactions.addReceipt', id)
        const data = new FormData()
        for (let i = 0; i < files.length; i ++) {
            data.append('img[]', files[i], files[i].name)
        }
        return await api.postFormData(url, data)
    },
    async markControlled (id) {
        const url = route('api.accounting.transactions.markControlled', id)
        return await api.post(url)
    },
    async undoControlled (id) {
        const url = route('api.accounting.transactions.undoControlled', id)
        return await api.delete(url)
    },
    async undoBooking (id) {
        const url = route('api.accounting.transactions.undoBooking', id)
        return await api.put(url)
    },
    async attendees () {
        const url = route('api.accounting.transactions.attendees')
        return await api.get(url)
    },
    async categories () {
        const url = route('api.accounting.transactions.categories')
        return await api.get(url)
    },
    async projects () {
        const url = route('api.accounting.transactions.projects')
        return await api.get(url)
    },
    async secondaryCategories () {
        const url = route('api.accounting.transactions.secondaryCategories')
        return await api.get(url)
    },
    async locations () {
        const url = route('api.accounting.transactions.locations')
        return await api.get(url)
    },
    async costCenters () {
        const url = route('api.accounting.transactions.costCenters')
        return await api.get(url)
    },
    async nextFreeReceiptNumber (walletId) {
        const url = route('api.accounting.transactions.nextFreeReceiptNumber', walletId)
        return await api.get(url)
    },
}

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
    async updateReceipt (id, files) {
        const url = route('api.accounting.transactions.updateReceipt', id)
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
    }
}

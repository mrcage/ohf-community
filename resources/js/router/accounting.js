import Vue from 'vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import PageHeader from '@/components/ui/PageHeader'
import WalletsIndexPage from '@/pages/accounting/WalletsIndexPage'
import WalletCreatePage from '@/pages/accounting/WalletCreatePage'
import WalletEditPage from '@/pages/accounting/WalletEditPage'
import SuppliersIndexPage from '@/pages/accounting/SuppliersIndexPage'
import SupplierCreatePage from '@/pages/accounting/SupplierCreatePage'
import SupplierViewPage from '@/pages/accounting/SupplierViewPage'
import SupplierDetails from '@/components/accounting/SupplierDetails'
import SupplierTransactions from '@/components/accounting/SupplierTransactions'
import SupplierEditPage from '@/pages/accounting/SupplierEditPage'
import TransactionCreatePage from '@/pages/accounting/TransactionCreatePage'
import TransactionsIndexPage from '@/pages/accounting/TransactionsIndexPage'
import TransactionViewPage from '@/pages/accounting/TransactionViewPage'
import TransactionEditPage from '@/pages/accounting/TransactionEditPage'
import NotFoundPage from '@/pages/NotFoundPage'

import i18n from '@/plugins/i18n'

import { can } from '@/plugins/laravel'

export default new VueRouter({
    mode: 'history',
    base: '/accounting/',
    routes: [
        {
            path: '/wallets',
            name: 'accounting.wallets.index',
            components: {
                default: WalletsIndexPage,
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('app.overview'),
                    buttons: [
                        {
                            to: { name: 'accounting.wallets.create' },
                            variant: 'primary',
                            icon: 'plus-circle',
                            text: i18n.t('app.add'),
                            show: can('configure-accounting')
                        },
                    ]
                }
            }
        },
        {
            path: '/wallets/create',
            name: 'accounting.wallets.create',
            components: {
                default: WalletCreatePage,
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('accounting.create_wallet')
                }
            }
        },
        {
            path: '/wallets/:id/edit',
            name: 'accounting.wallets.edit',
            components: {
                default: WalletEditPage,
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('accounting.edit_wallet'),
                }
            }
        },
        {
            path: '/wallets/:walletId/transactions',
            name: 'accounting.transactions.index',
            components: {
                default: TransactionsIndexPage,
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('accounting.transactions'),
                }
            }
        },
        {
            path: '/wallets/:walletId/transactions/create',
            name: 'accounting.transactions.create',
            components: {
                default: TransactionCreatePage,
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('accounting.register_new_transaction'),
                }
            }
        },
        {
            path: '/transactions/:id',
            name: 'accounting.transactions.show',
            components: {
                default: TransactionViewPage,
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('accounting.transaction'),
                }
            }
        },
        {
            path: '/transactions/:id/edit',
            name: 'accounting.transactions.edit',
            components: {
                default: TransactionEditPage,
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('accounting.edit_transaction'),
                }
            }
        },
        {
            path: '/suppliers',
            name: 'accounting.suppliers.index',
            components: {
                default: SuppliersIndexPage,
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('app.overview'),
                    buttons: [
                        {
                            to: { name: 'accounting.suppliers.create' },
                            variant: 'primary',
                            icon: 'plus-circle',
                            text: i18n.t('app.add'),
                            show: can('manage-suppliers')
                        },
                    ]
                }
            }
        },
        {
            path: '/suppliers/create',
            name: 'accounting.suppliers.create',
            components: {
                default: SupplierCreatePage,
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('accounting.register_supplier')
                }
            }
        },
        {
            path: '/suppliers/:id',
            components: {
                default: SupplierViewPage,
                header: PageHeader
            },
            props: {
                default: true,
                header: (route) => ({
                    title: i18n.t('accounting.supplier'),
                    buttons: [
                        {
                            to: { name: 'accounting.suppliers.index' },
                            variant: 'secondary',
                            icon: 'arrow-left',
                            text: i18n.t('app.overview'),
                            show: true
                        },
                        {
                            to: { name: 'accounting.suppliers.edit', params: { id: route.params.id } },
                            variant: 'primary',
                            icon: 'edit',
                            text: i18n.t('app.edit'),
                            show: can('manage-suppliers')
                        },
                    ]
                })
            },
            children: [
                {
                    path: '',
                    name: 'accounting.suppliers.show',
                    component: SupplierDetails,
                    props: true
                },
                {
                    path: 'transactions',
                    name: 'accounting.suppliers.show.transactions',
                    component: SupplierTransactions,
                    props: true
                }
            ],
        },
        {
            path: '/suppliers/:id/edit',
            name: 'accounting.suppliers.edit',
            components: {
                default: SupplierEditPage,
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('accounting.edit_supplier'),
                }
            }
        },
        {
            path: '*',
            component: NotFoundPage
        }
    ]
})

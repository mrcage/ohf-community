import Vue from 'vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import PageHeader from '@/components/ui/PageHeader'
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
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/WalletsIndexPage'),
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('Overview'),
                    buttons: [
                        {
                            to: { name: 'accounting.wallets.create' },
                            variant: 'primary',
                            icon: 'plus-circle',
                            text: i18n.t('Add'),
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
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/WalletCreatePage'),
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('Create wallet')
                }
            }
        },
        {
            path: '/wallets/:id/edit',
            name: 'accounting.wallets.edit',
            components: {
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/WalletEditPage'),
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('Edit wallet'),
                }
            }
        },
        {
            path: '/suppliers',
            name: 'accounting.suppliers.index',
            components: {
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/SuppliersIndexPage'),
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('Overview'),
                    buttons: [
                        {
                            to: { name: 'accounting.suppliers.create' },
                            variant: 'primary',
                            icon: 'plus-circle',
                            text: i18n.t('Add'),
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
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/SupplierCreatePage'),
                header: PageHeader
            },
            props: {
                header:  {
                    title: i18n.t('Register Supplier')
                }
            }
        },
        {
            path: '/suppliers/:id',
            components: {
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/SupplierViewPage'),
                header: PageHeader
            },
            props: {
                default: true,
                header: (route) => ({
                    title: i18n.t('Supplier'),
                    buttons: [
                        {
                            to: { name: 'accounting.suppliers.index' },
                            variant: 'secondary',
                            icon: 'arrow-left',
                            text: i18n.t('Overview'),
                            show: true
                        },
                        {
                            to: { name: 'accounting.suppliers.edit', params: { id: route.params.id } },
                            variant: 'primary',
                            icon: 'edit',
                            text: i18n.t('Edit'),
                            show: can('manage-suppliers')
                        },
                    ]
                })
            },
            children: [
                {
                    path: '',
                    name: 'accounting.suppliers.show',
                    component: () => import(/* webpackChunkName: "accounting" */ '@/components/accounting/SupplierDetails'),
                    props: true
                },
                {
                    path: 'transactions',
                    name: 'accounting.suppliers.show.transactions',
                    component: () => import(/* webpackChunkName: "accounting" */ '@/components/accounting/SupplierTransactions'),
                    props: true
                }
            ],
        },
        {
            path: '/suppliers/:id/edit',
            name: 'accounting.suppliers.edit',
            components: {
                default: () => import(/* webpackChunkName: "accounting" */ '@/pages/accounting/SupplierEditPage'),
                header: PageHeader
            },
            props: {
                default: true,
                header: {
                    title: i18n.t('Edit Supplier'),
                }
            }
        },
        {
            path: '*',
            component: NotFoundPage
        }
    ]
})

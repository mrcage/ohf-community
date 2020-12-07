import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'

Vue.use(plugin)

import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init()

import VueMeta from 'vue-meta'
Vue.use(VueMeta, {
    refreshOnceOnNavigation: true
})

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue)

Vue.mixin({ methods: { route }})

const el = document.getElementById('app')

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./InertiaPages/${name}`).default,
        },
    }),
}).$mount(el)

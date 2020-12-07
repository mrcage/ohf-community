<template>
    <div>
        <header>
            <b-navbar toggleable="lg" type="dark" variant="dark" class="shadow-sm">
                <b-navbar-brand href="#">{{ $page.props.appName }}</b-navbar-brand>
                <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
                <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item v-for="link in links" :key="link.text" :href="link.href" :active="link.active">{{ link.text }}</b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right no-caret toggle-class="py-0">
                        <template #button-content>
                            <b-avatar variant="primary" :text="nameInitials($page.props.user.name)" size="32px" style="background: red"/>
                            <span class="d-lg-none ml-1">{{ $page.props.user.name }}</span>
                        </template>
                        <b-dropdown-item href="#">Profile</b-dropdown-item>
                        <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
                </b-collapse>
            </b-navbar>
            <div v-if="breadcrumbItems && breadcrumbItems.length > 0" class="border-bottom bg-white">
                <b-container>
                    <b-breadcrumb class="px-0 bg-white my-0" :items="breadcrumbItems"/>
                </b-container>
            </div>
            <!-- <inertia-link href="/">Home</inertia-link>
            <inertia-link href="/about">About</inertia-link>
            <inertia-link href="/contact">{{ route('api.users.index') }}</inertia-link> -->
        </header>
        <b-container tag="main" class="mt-3">
            <div v-if="$page.props.flash.message" class="alert alert-info">
                {{ $page.props.flash.message }}
            </div>
            <slot/>
        </b-container>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                links: [
                    {
                        text: 'Visitors',
                        href: '#'
                    },
                    {
                        text: 'Badges',
                        href: '#'
                    },
                    {
                        text: 'Library',
                        href: '#'
                    },
                    {
                        text: 'Users & Roles',
                        href: '#'
                    },
                    {
                        text: 'Settings',
                        href: '#'
                    }
                ],
                breadcrumbItems: [
                    {
                        text: 'Admin',
                        href: '#'
                    },
                    {
                        text: 'Manage',
                        href: '#'
                    },
                    {
                        text: 'Library',
                        active: true
                    }
                ]
            }
        },
        methods: {
            nameInitials (value) {
                const names = value.split(' ')
                let initials = names[0].substring(0, 1).toUpperCase()
                if (names.length > 1) {
                    initials += names[names.length - 1].substring(0, 1).toUpperCase()
                }
                return initials
            }
        }
    }
</script>

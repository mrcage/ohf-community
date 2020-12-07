<template>
    <article>
        <h1>Welcome</h1>
        <p>Hello <a :href="`mailto:$(user.email)`">{{ user.name }}</a>, welcome to your first Inertia app!</p>
        <h2>Some Text</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sint maxime delectus, aliquid cum mollitia iste. Ut in explicabo alias, deserunt asperiores repudiandae obcaecati voluptas adipisci animi. Reiciendis possimus excepturi officiis!</p>
        <ul>
            <li v-for="volunteer in volunteers" :key="volunteer.id">
                {{ volunteer.first_name }} / {{ volunteer.family_name }}
            </li>
        </ul>
    </article>
</template>

<script>
    import Layout from './Layout'
    export default {
        metaInfo() {
            return {
                title: `Welcome ${this.user.name}`,
            }
        },
        layout: Layout,
        props: {
            user: Object,
            volunteers: Array,
        }
    }
</script>

<style scoped>
    h1, h2, h3 {
        font-weight: lighter;
    }
</style>

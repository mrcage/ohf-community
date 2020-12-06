<template>
    <iframe :src="source" width="1920px" height="1080px" />
</template>

<script>
export default {
    props: {
        source: {
            required: true,
        }
    }
}
</script>

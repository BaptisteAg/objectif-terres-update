<template>
    <VueRssFeed :feedUrl="src" :name="name" :limit="limit"/>
</template>

<script>
    import VueRssFeed from "vue-rss-feed/src/VueRssFeed";

    export default {
        name: "Test",
        components: {
            VueRssFeed
        },
        props: {
            src: String
        },
        data() {
            return {
                name: "rss",
                limit: 5,
            };
        },
    };

</script>

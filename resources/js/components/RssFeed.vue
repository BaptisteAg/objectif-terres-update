<template>
    <VueRssFeed :feedUrl="feedUrl" :name="name" :limit="limit"/>
</template>

<script>
    import VueRssFeed from "vue-rss-feed/src/VueRssFeed";

    export default {
        name: "Test",
        components: {
            VueRssFeed
        },
        data() {
            return {
                feedUrl: "https://terredeliens.org/spip.php?page=backend&id_rubrique=7",
                name: "test",
                limit: 5,
            };
        },
    };

</script>

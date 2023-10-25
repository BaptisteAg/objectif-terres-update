<template>
    <b-carousel>
        <template v-if="images.length > 0">
            <b-carousel-item v-for="(image, i) in images" :key="i">
                <b-image class="image is-3by2 vignette__image" :src="'https://objectif-terres.org/' + image.path"></b-image>
            </b-carousel-item>
        </template>
        <b-carousel-item v-else>
            <b-image class="image is-3by2 vignette__image" src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"></b-image>
        </b-carousel-item>
    </b-carousel>
</template>

<script>
export default {
    props: ['images']
}
</script>

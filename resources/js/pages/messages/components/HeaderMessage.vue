<template>
    <div>
        <div class="content ">
            <p class="title is-4 has-text-centered">Nom de la personne</p>
            <a href=""><p class="subtitle is-6 has-text-centered">Titre de l'annonce</p></a>
        </div>
        <hr>
    </div>
</template>

<script>
    export default {
        props: {},
        mounted: function () {
            console.log('header')
        }
    }
</script>

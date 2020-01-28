<template>
    <div class="field">
        <label for="ad_type" class="label">Type d'annonce</label>
        <div class="select">
            <select id="ad_type"
                    v-bind:value="value"
                    v-on:input="$emit('input', $event.target.value)">
                <option value="" selected>Choisir un type d'annonce...</option>
                <option :value="val" v-for="(label,val) in adTypes">{{ label }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                required: true
            },
        },
        computed: {
            adTypes() {
                return {
                    land_seek: "Recherche de foncier",
                    land_offer: "Offre de foncier",
                    job_ad: "Opportunité professionnelle",
                }
            }
        }
    }
</script>

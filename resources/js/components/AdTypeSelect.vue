<template>

    <div class="columns adTypes-container">
        <div class="column"></div>
        <div class="column is-half">
            <div class="field" v-if="displaySelection">

                <div class="is-pulled-left">
                    <label class="label" v-if="isSupportRequest">De quel accompagnement avez-vous besoin ?</label>
                    <label class="label" v-else>Quel type d'annonce souhaitez-vous publier ?</label>
                </div>
                <div class="is-pulled-right">
                    <a href="/faq" target="_blank">
                        Aide
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="columns adTypes" style="clear:both">
                    <div class="column adType"
                         v-for="(adType,adTypeValue) in adTypes"
                         :class="{active: value === adTypeValue}"
                         @click="_ => setAdType(adTypeValue)">

                        <img :src="'/images/icons/' + adType.img" v-if="adType.img">
                        <i :class="'fa-4x fa '+adType.icon" v-if="adType.icon"></i>

                        <br>
                        {{ adType.label }}
                        <br><br>
                        <small>Ex :{{ adType.examples }}</small>
                    </div>
                </div>
            </div>
            <div class="adType-selected" v-else>
                <label><i :class="'fa '+currentAdType.icon"></i> {{currentAdType.label}}</label><br>
                <a href="#" @click.prevent="displaySelection = true" v-if="isNew">← Changer de type d'annonce</a>
            </div>
            <input type="hidden" :name="name" :value="value">
        </div>
        <div class="column"></div>
    </div>
</template>

<style lang="scss" scoped>
    @import "../../sass/variables";

    label {
        font-size: 30px;
        font-family: $family-sans-serif;
    }

    .adTypes-container {
        background: rgba(0, 0, 0, 0.05);
        padding-bottom: 40px;
    }

    .adType {
        width: 300px;
        line-height: 23px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        font-size: 20px;
        font-family: $family-sans-serif;
        cursor: pointer;
        margin: 0 10px;
        text-align: center;
        background: #fff;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);

        &.active {
            background: $blue;
            color: white;
        }
    }
</style>

<script>
    export default {
        props: {
            value: {
                type: String,
                required: true
            },
            name: {
                type: String, 
                required: true
            },
            isSupportRequest: {
                type: Boolean,
                required: true
            },
            isNew: Boolean
        },
        data() {
            return {
                displaySelection: !this.value
            }
        },
        computed: {
            adTypes() {
                let extraAdTypes = this.isSupportRequest ? {} : {
                    job_seek: {
                        label: "Je cherche une opportunité professionnelle",
                        icon: "fa-universal-access",
                        examples: "Emploi, stage, associé.."
                    },
                    job_offer: {
                        label: "Je propose une opportunité professionnelle",
                        icon: "fa-universal-access",
                        examples: "Emploi, stage, associé.."
                    }
                };

                return {
                    land_seek: {
                        label: "Je cherche du foncier agricole",
                        img: "land_ad_type.png",
                        examples: "Terrain, ferme, parcelle..."
                    },
                    land_offer: {
                        label: "Je propose du foncier agricole",
                        img: "land_ad_type.png",
                        examples: "Terrain, ferme, parcelle..."
                    },
                    ...extraAdTypes
                }
            },
            currentAdType() {
                return this.adTypes[this.value];
            }
        },
        methods: {
            setAdType(adType) {
                this.$emit('input', adType);
                this.displaySelection = false;
            }
        }
    }
</script>

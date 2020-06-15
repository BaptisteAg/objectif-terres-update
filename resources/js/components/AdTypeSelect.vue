<template>

    <div class="columns adTypes-container">
        <div class="column"></div>
        <div class="column is-half">
            <div class="field" v-if="displaySelection">

                <label class="label" v-if="isSupportRequest">De quel accompagnement avez-vous besoin ?</label>
                <label class="label" v-else>Quel type d'annonce souhaitez-vous publier ?</label>

                <div class="columns adTypes">
                    <div class="column adType"
                         v-for="(adType,adTypeValue) in adTypes"
                         :class="{active: value === adTypeValue}"
                         @click="_ => setAdType(adTypeValue)">
                        <i :class="'fa-4x fa '+adType.icon"></i><br>
                        {{ adType.label }}
                    </div>
                </div>
            </div>
            <div class="adType-selected" v-else>
                <label><i :class="'fa '+currentAdType.icon"></i> {{currentAdType.label}}</label><br>
                <a href="#" @click.prevent="displaySelection = true">← Changer de type d'annonce</a>
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
        background: rgba(0,0,0,0.05);
        padding-bottom:40px;
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
            }
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
                        icon: "fa-universal-access"
                    },
                    job_offer: {
                        label: "Je propose une opportunité professionnelle",
                        icon: "fa-universal-access"
                    }
                };

                return {
                    land_seek: {
                        label: "Je cherche du foncier agricole",
                        icon: "fa-home"
                    },
                    land_offer: {
                        label: "Je propose du foncier agricole",
                        icon: "fa-home"
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

<template>
    <div class="container">
        <div
             class="searchTags objT-border is-flex py-4 px-5 my-3 columns is-multiline is-justify-content-space-between is-hidden-touch">
            <div
                v-for="(tag,i) in tags"
                :key="tag.label"
                :class="'gap-2 column is-4' + (i % 3 === 1 && i !== tags.length-1 ? ' has-text-centered' : '') + (i % 3 === 2 || i === tags.length-1 ? ' has-text-right' : '')">
                <strong class="flex-fit-content">{{ tag.label }}</strong>
                <span class="xthree-dots">{{ tag.value }}</span>
            </div>
        </div>
    </div>
</template>

<style>
.searchTags {
    background-color: #F8F3EE;
}
</style>

<script>
import {searchAdTypes} from "../definitions/searchAdTypes";

export default {
    props: {
        regions_searched: {
            type: Array
        },
        departments_searched: {
            type: Array
        },
        productions_searched: {
            type: Array
        },
        surface_searched: {
            type: Object
        },
        transmissions: Array,
        price_searched: {
            type: Object
        },
        rent_searched: {
            type: Object
        },
        water_access: {
            type: String
        },
        keywords: {
            type: String
        },
        installation_searched: {
            type: String
        },
        educations_searched: {
            type: Array
        },
        experiences_searched: {
            type: Array
        },
    },
    data() {
        return {
            params: new URLSearchParams(window.location.search),
            categoryLabels: searchAdTypes,
        }
    },
    computed: {
        tags() {
            const tags = [];
            tags.push({
                label: 'Je cherche',
                value: this.categoryLabels[this.params.get('ad_category')] || 'Tout'
            });
            tags.push({
                label: 'Localisation(s)',
                value: this.regions_searched.map(r => 'Région : ' + r)
                    .concat(this.departments_searched.map(r => 'Départment : ' + r))
                    .join(', ') || 'Non définie'
            });
            tags.push({
                label: 'Production principale',
                value: this.productions_searched.join(', ') || 'Non définie'
            });
            if(this.surface_searched?.min || this.surface_searched?.max) {
                const surface = this.surface_searched
                let value = 'Entre ' + surface.min + ' et ' + surface.max + ' ha';
                if(surface.min === surface.max) {
                    value = surface.min + ' ha';
                }
                if(!surface.min) {
                    value = 'Jusqu\'à ' + surface.max + ' ha';
                }
                if(!surface.max) {
                    value = 'A partir de ' + surface.min + ' ha';
                }
                tags.push({
                    label: 'Surface',
                    value
                });
            }
            if(this.transmissions.length) {
                tags.push({
                    label: 'Transmissions',
                    value: this.transmissions.join(', ')
                });
            }
            if(this.price_searched && this.price_searched.min || this.price_searched.max) {
                let value = 'Entre ' + this.price_searched.min + ' et ' + this.price_searched.max + ' €';
                if(this.price_searched.min === this.price_searched.max) {
                    value = this.price_searched.min + ' €';
                }
                if(!this.price_searched.min) {
                    value = 'Jusqu\'à ' + this.price_searched.max + ' €';
                }
                if(!this.price_searched.max) {
                    value = 'A partir de ' + this.price_searched.min + ' €';
                }
                tags.push({
                    label: 'Prix',
                    value
                });
            }
            if(this.rent_searched && this.rent_searched.min || this.rent_searched.max) {
                let value = 'Entre ' + this.rent_searched.min + ' et ' + this.rent_searched.max + ' €';
                if(this.rent_searched.min === this.rent_searched.max) {
                    value = this.rent_searched.min + ' €';
                }
                if(!this.rent_searched.min) {
                    value = 'Jusqu\'à ' + this.rent_searched.max + ' €';
                }
                if(!this.rent_searched.max) {
                    value = 'A partir de ' + this.rent_searched.min + ' €';
                }
                tags.push({
                    label: 'Loyer',
                    value
                });
            }
            if(this.water_access) {
                tags.push({
                    label: 'Accès à l\'eau',
                    value: this.water_access
                });
            }
            if(this.installation_searched) {
                tags.push({
                    label: 'Installation',
                    value: this.installation_searched
                });
            }
            if(this.educations_searched.length) {
                tags.push({
                    label: 'Formations',
                    value: this.educations_searched.join(', ')
                });
            }
            if(this.experiences_searched.length) {
                tags.push({
                    label: 'Expériences',
                    value: this.experiences_searched.join(', ')
                });
            }
            if(this.keywords) {
                tags.push({
                    label: 'Mots clés',
                    value: this.keywords
                });
            }

            return tags
        }
    }
}
</script>

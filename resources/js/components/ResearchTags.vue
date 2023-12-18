<template>
    <div class="container">
        <div
             class="searchTags objT-border is-flex py-4 px-5 my-3 columns is-multiline is-justify-content-space-between is-hidden-touch">
            <div
                v-for="(tag,i) in tags"
                :key="tag.label"
                :class="'gap-2 column is-4' + (i % 3 === 1 ? ' has-text-centered' : '') + (i % 3 === 2 ? ' has-text-right' : '')">
                <strong class="flex-fit-content">{{ tag.label }}</strong>
                <span class="three-dots">{{ tag.value }}</span>
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
        productions_searched: {
            type: Array
        },
        surface_searched: {
            type: Object
        }
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
                value: this.regions_searched.join(', ') || 'Non définie'
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

            return tags
        }
    }
}
</script>

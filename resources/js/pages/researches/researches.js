import {Pagination} from 'vue-pagination-2';

import Vue from 'vue';

Vue.Component('search', {
    components: {
        Pagination,
    },
    props: {
        options : {
            theme : 'bulma',
        },
    }
});

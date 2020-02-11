<template>
        <aside class="menu">
            <p class="menu-label">
                Liste de vos interlocuteurs
            </p>
            <ul class="menu-list">
                <li v-for ='thread in listOfThreads'>
                    <a>
                        <span v-for ='user in thread'>
                            <span>{{user.first_name}} </span>
                        </span>
                    </a>
                </li>
            </ul>
        </aside>
</template>

<script>
    export default {
        props: {
            values : Object,
        },
        data() {
            return {
                listOfThreads: this.values,
            }
        },
        mounted: function () {
            console.log('list threads')
        }
    }
</script>

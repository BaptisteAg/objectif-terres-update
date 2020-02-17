<template>
    <div>
        <template class="loader-wrapper" v-if="value.length === 0">
        </template>
        <div v-else class="content ">
            <template v-if="value[0].thread.users[0].id !== userId">
                <p class="title is-4 has-text-centered" >{{value[0].thread.users[0].first_name}} {{value[0].thread.users[0].name}}</p>
            </template>
            <template v-else>
                <p class="title is-4 has-text-centered" >{{value[0].thread.users[1].first_name}} {{value[0].thread.users[1].name}}</p>
            </template>
            <a :href="'/annonces/' + value[0].thread.ad.id"><p class="subtitle is-6 has-text-centered" >{{value[0].thread.ad.title}}</p></a>
          <br>
           <div class="content">
               <div class="buttons is-centered ">
                   <a :href="'/annonces/' + value[0].thread.ad.id">
                       <button class="button is-link ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
                           <span>Voir l'annonce</span>
                       </button>
                   </a>
               </div>
           </div>

        </div>
        <hr>
    </div>

</template>

<script>
    export default {
        props : {
            value: {},
            userId:{},
        },

    }
</script>

import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    data () {
        return {
            value: [{ name: 'Vue.js', language: 'JavaScript' }],
            options: [
                { name: 'Vue.js', language: 'JavaScript' },
                { name: 'Adonis', language: 'JavaScript' },
                { name: 'Rails', language: 'Ruby' },
                { name: 'Sinatra', language: 'Ruby' },
                { name: 'Laravel', language: 'PHP' },
                { name: 'Phoenix', language: 'Elixir' }
            ]
        }
    }
}

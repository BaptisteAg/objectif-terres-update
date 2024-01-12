 <template>
  <div class="list-threads">
    <div class="content" v-if="isDisplay">
      <template v-if="numberThreadsUnreadMessages <=1">
        <p class="number-of-unread-message text_danger has-text-weight-medium">{{ numberThreadsUnreadMessages }}
          discussion non lue</p>
      </template>
      <template v-else>
        <p class="number-of-unread-message text_danger has-text-weight-medium">{{ numberThreadsUnreadMessages }}
          discussions non lues</p>
      </template>
      <button v-if="isUserTdlMember" @click="onNewThreadClick" class="open-modal-new-message button primary basic"
              type="button">
        <span class="icon is-small">
          <i class="fa fa-plus" aria-hidden="true"></i>
        </span>
        <span> Créer une discussion</span>
      </button>
    </div>
    <aside class="menu">
      <p class="menu-label" v-if="isDisplay">
        Vos discussions
      </p>
      <p class="menu-label" v-else>
        Fils de discussion
      </p>
      <ul class="menu-list">
        <template v-for="thread in threads">
          <li :class="{'thread-with-unread-messages' : threadsUnreadMessages?.includes(thread.id), 'active-thread' : thread.id === activeThread }"
              style=" list-style-type: none">
            <template v-if="isDisplay">
              <template v-if="thread.users.length > 2">
                <a @click="onThreadClick(thread.id)">
                  <span class="tag ">Membres TdL</span>
                  <span>{{ thread.title }}</span>
                </a>
              </template>
              <template v-else-if="thread.ad_id !== null">
                <template v-if="thread.ad.user_pp_id === userId">
                  <a @click="onThreadClick(thread.id)">
                    <template v-if="thread.ad.project_id !== null">
                      <span class="tag">Réponse accompagnement</span>
                    </template>
                    <template v-else>
                      <span class="tag">Réponse annonce</span>
                    </template>
                    <span>{{ thread.title }}</span>
                    <span class="text_size small">{{ thread.ad.title }}</span>
                  </a>
                </template>
                <template v-else>
                  <a @click="onThreadClick(thread.id)">
                    <template v-if="thread.ad.project_id !== null">
                      <span class="tag">Accompagnement</span>
                    </template>
                    <template v-else>
                      <span class="tag">Annonce</span>
                    </template>
                    <template v-if="thread.ad.deleted_at !== null">
                      Annonce supprimée
                    </template>
                    <template v-else>
                      <span>{{ thread.title }}</span>
                    </template>
                    <br>
                  </a>
                </template>
              </template>
              <template v-else>
                <a @click="onThreadClick(thread.id)">
                  <span class="tag">Membre TdL</span>
                  <span>{{ thread.title }}</span>
                </a>
              </template>
            </template>
            <template v-else>
              <template v-if="thread.users.length > 2">
                <a @click="onThreadClick(thread.id)">
                  <span class="tag ">Membres TdL</span>
                  <span>{{ thread.title }}</span>
                </a>
              </template>
              <template v-else-if="thread.ad_id !== null">
                <template v-if="thread.ad.user_pp_id === userId">
                  <a @click="onThreadClick(thread.id)">
                    <template v-if="thread.ad.project_id !== null">
                      <span class="tag">Réponse accompagnement</span>
                    </template>
                    <template v-else>
                      <span class="tag">Réponse annonce</span>
                    </template>
                    <span>{{ thread.title }}</span>
                    <span class="text_size small">{{ thread.ad.title }}</span>
                  </a>
                </template>
                <template v-else>
                  <a @click="onThreadClick(thread.id)">
                    <template v-if="thread.ad.project_id !== null">
                      <span class="tag">Accompagnement</span>
                    </template>
                    <template v-else>
                      <span class="tag">Annonce</span>
                    </template>
                    <template v-if="thread.ad.deleted_at !== null">
                      Annonce supprimée
                    </template>
                    <template v-else>
                      <span>{{ thread.title }}</span>
                    </template>
                    <br>
                  </a>
                </template>
              </template>
              <template v-else>
                <a @click="onThreadClick(thread.id)">
                  <span class="tag">Membre TdL</span>
                  <span>{{ thread.title }}</span>
                </a>
              </template>
            </template>
          </li>
        </template>

      </ul>
    </aside>
  </div>

</template>

<script>
import axios from 'axios'

export default {
  props: {
    threads: '',
    numberOfThreadsWithUnreadMessages: '',
    threadsWithUnreadMessages: '',
    isDisplay: Boolean,
    userId: {},
    userRole: '',
    activeThread: ''
  },
  data() {
    return {
      numberThreadsUnreadMessages: this.numberOfThreadsWithUnreadMessages,
      threadsUnreadMessages: this.threadsWithUnreadMessages,
      isUserTdlMember: this.userRole >= 1,
      activeThreadId: this.activeThread,
    }
  },
  methods: {
    onThreadClick(threadId) {
      this.$emit('on-thread-click', threadId);
      axios.get('/mon-espace/messagerie/actualisation')
          .then(response => (
              this.threadsUnreadMessages = response.data,
                  this.numberThreadsUnreadMessages = response.data.length
          ))
    },
    onNewThreadClick() {
      this.$emit('on-new-thread-click')
    }

  },

}
</script>

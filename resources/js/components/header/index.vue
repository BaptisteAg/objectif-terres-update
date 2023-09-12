<template>
  <div>
    <mobile-header :routes="routes"
                   :unread_messages = "unread_messages"
                   :unread_notifications = "unread_notifications"
    ></mobile-header>
    <top-header
        :routes="{ home: routes.home, login: routes.login, logout: routes.logout, account: routes.account,messages: routes.messages, notifications: routes.notifications , administration: { role_4: routes.role_4, role_3: routes.role_3, role_2: routes.role_2, role_1: routes.role_1 } }"
        :unread_messages = "unread_messages"
        :unread_notifications = "unread_notifications"
    ></top-header>
    <bottom-header
        :routes="{ about_us: routes.about_us, create_ads: routes.create_ads, all_ads: routes.all_ads }"></bottom-header>
  </div>
</template>
<script>
import MobileHeader from './mobile.vue';
import TopHeader from './top.vue';
import BottomHeader from './bottom.vue';

export default {
  components: {
    'mobile-header': MobileHeader,
    'top-header': TopHeader,
    'bottom-header': BottomHeader
  },
  props: ['routes', 'unread_messages', 'unread_notifications']
}
</script>
<style lang="scss">
header, header nav.navbar {
  background-color: #F8F3EE;
}
</style>

<template>
  <div class="k-dashboard">
    <k-drawer v-model="openDrawer"/>
    <k-toolbar :userName="userName" @logout="logout" @onClick="toogle"/>
    <router-view></router-view>
  </div>
</template>

<script>
import KToolbar from '../components/KToolbar'
import KDrawer from '../components/KDrawer'
import LocalStorage from '../utils/LocalStorage'
import VueRouter from 'vue-router'

export default {
  name: 'k-dashboard',
  components: {
    KToolbar,
    KDrawer
  },
  data () {
    return {
      userName: LocalStorage.get("SESSION_KABUM").session.nome,
      openDrawer: false
    }
  },
  methods: {
    logout(){
      LocalStorage.remove("SESSION_KABUM");
      this.$router.push('/')
    },
    toogle(open){
     this.openDrawer = !this.openDrawer
    }
  }
}
</script>
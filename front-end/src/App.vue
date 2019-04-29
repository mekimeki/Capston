<template>
  <v-app style="background: #FFFFFF;">
    <header_></header_>
    <router-view></router-view>
  </v-app>
</template>

<script>
import header_ from '@/components/mainPage_/Header';
import { mapActions,mapGetters } from 'vuex';//vuex actions import
export default {
  name: 'App',
  components: {
    header_,
  },
  data () {
    return {
      login:'',
    }
  },
  methods:{
    ...mapActions(['login_check_actions']),
  },
  mounted:function(){
    // this.login_check_actions(localStorage.getItem('login'));
  }
}
</script>

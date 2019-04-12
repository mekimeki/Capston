<template lang="html">
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex>
        <v-card>
          <img
          src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIBf9WyBle6QKL58EizMmabk4_qo7iJd6t-KoRMYkc75AoKx_r"
          alt="다양한 방법으로 공부해 보아요"
          width="200"
          height="470">
        </v-card>
      </v-flex>
      <v-flex>
        <v-card class="pa-5" v-if="lp_getters == 1">
          <login_></login_>
        </v-card>

        <v-card class="pa-5" v-else-if="lp_getters == 2">
          <loginRegister_></loginRegister_>
        </v-card>

        <v-card class="pa-5" v-else-if="lp_getters == 3">
          <loginRegister_></loginRegister_>
        </v-card>

      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import login_ from '@/components/login_/Login';
import loginRegister_ from '@/components/login_/LoginRegister';
import { mapGetters, mapActions } from 'vuex';//vuex actions import
export default {
  components:{
    login_,
    loginRegister_,
  },
  data(){
    return{
      check:1,
    }
  },
  methods:{
    ...mapActions(['login_page_actions']),

  },
  computed:{
    ...mapGetters({
      lp_getters:'login_page_getters'
    }),
  },
  mounted:function(){
    this.login_page_actions(1);
  }

}
</script>

<style lang="css" scoped>
</style>

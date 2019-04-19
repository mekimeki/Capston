<template lang="html">
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex xs12 sm6>
        <v-card class="pa-2">
          <img
          src="https://img.huffingtonpost.com/asset/5b3c7f602000004200b961ba.jpeg?ops=scalefit_630_noupscale"
          alt="다양한 방법으로 공부해 보아요"
          width="100%"
          >
        </v-card>
      </v-flex>
      <v-flex xs12 sm6>
        <router-view></router-view>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import login_ from '@/components/login_/Login';
import loginRegister_ from '@/components/login_/LoginRegister';
export default {
  components:{
    login_,
    loginRegister_,
  },
}
</script>

<style lang="css" scoped>
</style>

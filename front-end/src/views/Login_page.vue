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

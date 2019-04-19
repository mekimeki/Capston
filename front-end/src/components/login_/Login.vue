<template lang="html">
  <v-form
    ref="form"
    lazy-validation
  >
    <v-text-field
      v-model="login.email"
      label="E-mail"
      required
    ></v-text-field>

    <v-text-field
      v-model="login.password"
      type="password"
      label="PassWord"
      required
    ></v-text-field>

    <v-flex>
      <v-btn
        block
        v-on:click="login_click()"
      >
        로그인
      </v-btn>
      <v-flex>
        <v-btn
          flat small
          right
          color="primary"
          v-on:click="$router.push({ name: 'register'})"
        >
          회원가입
        </v-btn>
        <v-btn
          flat small
          left
          color="primary"
          v-on:click="$router.push({ name: 'password'})"
        >
          비밀번호찾기
        </v-btn>
      </v-flex>
    </v-flex>

    <v-flex>
      <v-btn
        block
        color="success"
      >
        LINE
      </v-btn>
      <v-btn
        block
        color="primary"
      >
        FACEBOOK
      </v-btn>
      <v-btn
        block
        color="red"
      >
        Google
      </v-btn>
    </v-flex>

  </v-form>
</template>

<script>
import { mapActions,mapGetters } from 'vuex';//vuex actions import
import axios from 'axios';

export default {
  data(){
    return{
      login:{
        email:"",
        password:"",
      },
    }
  },
  methods:{
    ...mapActions(['login_actions','login_page_actions']),
    login_click(){
      this.login_actions(this.login);
      this.login.email = "";
      this.login.password = "";
    }
  },
  mounted:function(){
    if(localStorage.getItem('login')){
      this.$router.push({name:'main'});
    }
  },
  updated:function(){
    if(localStorage.getItem('login')){
      this.$router.push({name:'main'});
    }
  },
  computed:{
    ...mapGetters({
    }),

  }
}
</script>

<style lang="css" scoped>
</style>

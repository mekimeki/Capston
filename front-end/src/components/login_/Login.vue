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
      label="PassWord"
      required
    ></v-text-field>

    <v-flex>
      <v-btn
        block
        v-on:click="login_actions(login)"
      >
        로그인
      </v-btn>
      <v-flex>
        <v-btn
          flat small
          right
          color="primary"
          v-on:click="login_page_actions(2)"
        >
          회원가입
        </v-btn>
        <v-btn
          flat small
          left
          color="primary"
          v-on:click="login_page_actions(3)"
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
  },
  computed:{
    ...mapGetters({

    }),

  }
}
</script>

<style lang="css" scoped>
</style>

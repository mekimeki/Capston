<template lang="html">
  <v-form
    ref="form"
    lazy-validation
  >

    <v-text-field

      label="NickName"
      required
    ></v-text-field>

    <v-text-field

      label="E-mail"
      required
    ></v-text-field>

    <v-text-field

      label="PassWord"
      required
    ></v-text-field>

    <v-flex>
      <v-select
        :items="language"
        label="관심언어"
      ></v-select>
      <v-select
        :items="kategori"
        label="카테고리"
      ></v-select>
    </v-flex>

    <v-btn
      block
    >
      회원가입
    </v-btn>

  </v-form>
</template>

<script>
export default {
  data(){
    return{
      register:{
        nickanme:"",
        email:"",
        password:"",
      },
      language:[
         { text: '일본어'},
        { text: '한국어'},
        { text: '영어'},
      ],
      kategori:[
         { text: '1'},
        { text: '2'},
      ],
    }
  },
}
</script>

<style lang="css" scoped>
</style>

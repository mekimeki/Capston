<template lang="html">
  <div class="">
    <v-container>
      <nav_></nav_>
      <section_></section_>
      <search_></search_>
    </v-container>
    <footer_></footer_>
  </div>
</template>

<script>
import nav_ from '@/components/mainPage_/Nav';
import section_ from '@/components/mainPage_/Section';
import footer_ from '@/components/mainPage_/Footer';
import search_ from '@/components/mainPage_/Search';

export default {
  components:{
    nav_,
    section_,
    footer_,
    search_,
  },
  data(){
    return{

    }
  },

}
</script>

<style lang="css" scoped>
</style>

<template lang="html">
  <v-container>
    <nav_></nav_>
    <br>
    <section_></section_>
  </v-container>
</template>

<script>
import nav_ from '@/components/mainPage_/Nav';
import section_ from '@/components/mainPage_/Section';
import box_ from '@/components/mainPage_/Box';

export default {
  components:{
    nav_,
    section_,
    box_
  },
  data(){
    return{

    }
  },

}
</script>

<style lang="css" scoped>
</style>

<template lang="html">
  <v-container >
    <register_></register_>
    <recommend_></recommend_>
  </v-container>
</template>

<script>
import header_ from '@/components/mainPage_/Header';
import recommend_ from '@/components/mainPage_/Recommend';
import register_ from '@/components/mainPage_/Register';

export default {
  components:{
    header_,
    recommend_,
    register_,
  },
  data(){
    return{

    }
  },

}
</script>

<style lang="css" scoped>
</style>

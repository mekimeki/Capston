<template lang="html">
  <div>
    <header_></header_>
    <v-container>
    <register_></register_>
    <recommend_></recommend_>
    </v-container>
  </div>
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
.container{
    max-width: 80%
}
</style>

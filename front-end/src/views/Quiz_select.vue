<template lang="html">
  <div>
    <header_></header_>
    <v-container>
    <qselect_></qselect_>
    </v-container>
  </div>
</template>

<script>
import header_ from '@/components/mainPage_/Header';
import qselect_ from '@/components/quizPage_/Qselect';

export default {
  components:{
    header_,
    qselect_,
    
  },
  data(){
    return{

    }
  },

}
</script>

<style lang="css" scoped>
</style>

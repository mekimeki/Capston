<template lang="html">
  <div>
    <header_></header_>
    <v-container>
    <quizone_></quizone_>
    </v-container>
  </div>
</template>

<script>
import header_ from '@/components/mainPage_/Header';
import quizone_ from '@/components/quizPage_/QuizOne';

export default {
  components:{
    header_,
    quizone_,
  },
  data(){
    return{

    }
  },

}
</script>

<style lang="css" scoped>
</style>
